<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Setting\Controllers\AdminsettingController;

class AdminsettingControllerListener
{
    public function adminListFilter(
        Event $event,
        AdminsettingController $controller,
        AdminlistFormInterface $form
    ): string
    {
        $form->addNameField($form);
        $form->addPublishedField($form);

        return $form->renderForm(
            $controller->getLink() . '/' . $controller->router->getActionName(),
            'adminFilter'
        );
    }
}