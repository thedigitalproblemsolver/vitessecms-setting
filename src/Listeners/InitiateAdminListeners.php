<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Setting\Controllers\AdminsettingController;
use VitesseCms\Setting\Enum\SettingEnum;
use VitesseCms\Setting\Listeners\Admin\AdminMenuListener;
use VitesseCms\Setting\Listeners\Controllers\AdminsettingControllerListener;
use VitesseCms\Setting\Repositories\SettingRepository;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(SettingEnum::SERVICE_LISTENER->value, new ServiceListener(
            $di->cache,
            $di->configuration,
            new SettingRepository()
        ));
        $di->eventsManager->attach(AdminsettingController::class, new AdminsettingControllerListener());
    }
}
