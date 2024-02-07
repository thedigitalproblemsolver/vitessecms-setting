<?php
declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Setting\Enum\SettingEnum;
use VitesseCms\Setting\Listeners\Admin\AdminMenuListener;
use VitesseCms\Setting\Repositories\SettingRepository;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        if ($injectable->user->hasAdminAccess()):
            $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $injectable->eventsManager->attach(
            SettingEnum::SERVICE_LISTENER->value,
            new ServiceListener(
                $injectable->cache,
                $injectable->configuration,
                new SettingRepository()
            )
        );
    }
}
