<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    protected array $packageRoles = [
        'payments',
        'paymentsManager',
        'cardAssignment',
        'cardCreation',
        'cardCvv',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            return;
        }

        foreach ($this->getRoleNames() as $roleName) {
            $this->firstOrCreateRole($roleName);
        }

        $this->forgetCachedPermissions();
    }

    public function down(): void
    {
        $this->forgetCachedPermissions();
    }

    protected function getRoleNames(): array
    {
        return array_values(array_unique(array_merge(
            config('payments.defaultRoles', []),
            $this->packageRoles
        )));
    }

    protected function firstOrCreateRole(string $roleName): void
    {
        $guardName = config('auth.defaults.guard', 'web');
        $roleClass = config('permission.models.role');

        if ($roleClass && class_exists($roleClass)) {
            $usesSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($roleClass), true);

            $query = $usesSoftDeletes
                ? $roleClass::withTrashed()
                : $roleClass::query();

            $role = $query
                ->where('name', $roleName)
                ->where('guard_name', $guardName)
                ->first();

            if (! $role) {
                $roleClass::create([
                    'name' => $roleName,
                    'guard_name' => $guardName,
                ]);

                return;
            }

            if ($usesSoftDeletes && $role->trashed()) {
                $role->restore();
            }

            return;
        }

        if ($this->roleExists($roleName, $guardName)) {
            if (Schema::hasColumn('roles', 'deleted_at')) {
                $payload = ['deleted_at' => null];

                if (Schema::hasColumn('roles', 'updated_at')) {
                    $payload['updated_at'] = now();
                }

                DB::table('roles')
                    ->where('name', $roleName)
                    ->where('guard_name', $guardName)
                    ->update($payload);
            }

            return;
        }

        DB::table('roles')->insert($this->buildRolePayload($roleName, $guardName));
    }

    protected function roleExists(string $roleName, string $guardName): bool
    {
        $query = DB::table('roles')
            ->where('name', $roleName)
            ->where('guard_name', $guardName);

        return $query->exists();
    }

    protected function buildRolePayload(string $roleName, string $guardName): array
    {
        $payload = [
            'name' => $roleName,
            'guard_name' => $guardName,
        ];

        if (Schema::hasColumn('roles', 'created_at')) {
            $payload['created_at'] = now();
        }

        if (Schema::hasColumn('roles', 'updated_at')) {
            $payload['updated_at'] = now();
        }

        return $payload;
    }

    protected function forgetCachedPermissions(): void
    {
        if (class_exists(PermissionRegistrar::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }
};
