<?php

namespace IlBronza\Payments\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;

/**
 * Resolves allowed roles for Payments routes from config (payments.defaultRoles / payments.routeRoles).
 */
class PaymentsMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'payments';
}
