<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use VitesseCms\Admin\Models\AdminMenu;
use VitesseCms\Admin\Models\AdminMenuNavBarChildren;
use Phalcon\Events\Event;

class AdminMenuListener
{
    public function AddChildren(Event $event, AdminMenu $adminMenu): void
    {
        if ($adminMenu->getUser()->getPermissionRole() === 'superadmin') :
            $children = new AdminMenuNavBarChildren();
            $children->addChild('Settings', 'admin/setting/adminsetting/adminList');

            $adminMenu->addDropdown('System', $children);
        endif;
    }
}
