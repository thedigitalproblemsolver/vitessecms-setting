<?php declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Forms\SettingForm;
use VitesseCms\Setting\SettingInterface;

class SettingBlock implements SettingInterface
{
    public function buildAdminForm(SettingForm $form, Setting $item)
    {
        $form->addDropdown('%ADMIN_VALUE%', 'value', (new Attributes())
            ->setRequired()
            ->setOptions(ElementHelper::modelIteratorToOptions(
                $form->repositories->block->findAll(null, false)
            ))
        );
    }
}
