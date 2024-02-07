<?php
declare(strict_types=1);

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
    public static function setListeners(InjectableInterface $injectable): void
    {
        $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        $injectable->eventsManager->attach(
            SettingEnum::SERVICE_LISTENER->value,
            new ServiceListener(
                $injectable->cache,
                $injectable->configuration,
                new SettingRepository()
            )
        );
        $injectable->eventsManager->attach(AdminsettingController::class, new AdminsettingControllerListener());
    }
}
