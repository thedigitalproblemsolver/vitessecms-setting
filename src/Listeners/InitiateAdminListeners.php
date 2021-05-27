<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Setting\Controllers\AdminsettingController;
use VitesseCms\Setting\Listeners\Admin\AdminMenuListener;
use VitesseCms\Setting\Listeners\Controllers\AdminsettingControllerListener;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(AdminsettingController::class, new AdminsettingControllerListener());
    }
}
