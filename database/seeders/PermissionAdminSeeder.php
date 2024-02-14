<?php

namespace Database\Seeders;

use App\Enums\CustomerRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionAdminSeeder extends Seeder
{
    const NAME = CustomerRole::ADMIN;
    const GUARD = 'api-admin';
    protected $actions  = [
        'view',
        'create',
        'update',
        'delete',
    ];
    private $resourcePermissions = [
        'comment',
    ];
    private $singlePermissions = [
        'view profile'
    ];

    public function run()
    {
        $role = Role::firstOrCreate(['name' => self::NAME, 'guard_name' => self::GUARD]);
        createAndGiveResourcePermission($role, $this->actions, $this->resourcePermissions, self::GUARD);
        createAndGivePermission($role, $this->singlePermissions, self::GUARD);
    }
}
