<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Forms\SettingForm;
use VitesseCms\Setting\SettingInterface;

class SettingDatagroup implements SettingInterface
{
    public function buildAdminForm(SettingForm $form): void
    {
        $form->addDropdown(
            '%ADMIN_VALUE%',
            'value',
            (new Attributes())
                ->setRequired()
                ->setOptions(
                    ElementHelper::modelIteratorToOptions(
                        $form->repositories->datagroup->findAll(null, false)
                    )
                )
        );
    }
}
