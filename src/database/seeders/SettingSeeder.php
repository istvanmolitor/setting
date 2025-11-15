<?php

namespace Molitor\Setting\database\seeders;

use Illuminate\Database\Seeder;
use Molitor\User\Exceptions\PermissionException;
use Molitor\User\Services\AclManagementService;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            /** @var AclManagementService $aclService */
            $aclService = app(AclManagementService::class);
            $aclService->createPermission('setting', 'Beállítások', 'admin');
        } catch (PermissionException $e) {
            $this->command->error($e->getMessage());
        }
    }
}
