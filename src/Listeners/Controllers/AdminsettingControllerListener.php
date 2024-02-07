<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Controllers\AdminsettingController;
use VitesseCms\Setting\Utils\SettingUtil;

class AdminsettingControllerListener
{
    public function adminListFilter(
        Event $event,
        AdminsettingController $controller,
        AdminlistFormInterface $form
    ): string {
        $form->addNameField();
        $form->addDropdown(
            '%ADMIN_TYPE%',
            'filter[type]',
            (new Attributes())->setOptions(SettingUtil::getTypes($form->configuration))
        );
        $form->addPublishedField();

        return $form->renderForm(
            $controller->getLink().'/'.$controller->router->getActionName(),
            'adminFilter'
        );
    }
}