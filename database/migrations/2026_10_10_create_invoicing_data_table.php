<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('payments.models.invoicingData.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('invoicing_dataable', 'payments_invoicing_dataable_index');
            $table->string('vat')->nullable();
            $table->string('rea_number')->nullable();
            $table->string('istat_code')->nullable();
            $table->string('ateco_code')->nullable();
            $table->boolean('pubblica_amministrazione')->default(false);
            $table->string('sdi', 7)->nullable();
            $table->boolean('split_payment')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('payments.models.invoicingData.table'));
    }
};
