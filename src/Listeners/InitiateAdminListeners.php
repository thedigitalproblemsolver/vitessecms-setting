<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use Phalcon\Events\Manager;
use VitesseCms\Setting\Controllers\AdminsettingController;

class InitiateAdminListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
        $eventsManager->attach(AdminsettingController::class, new AdminsettingControllerListener());
    }
}
