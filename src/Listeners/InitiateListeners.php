<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Setting\Enum\SettingEnum;
use VitesseCms\Setting\Listeners\Admin\AdminMenuListener;
use VitesseCms\Setting\Repositories\SettingRepository;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if ($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $di->eventsManager->attach(SettingEnum::SERVICE_LISTENER->value, new ServiceListener(
            $di->cache,
            $di->configuration,
            new SettingRepository()
        ));
    }
}
