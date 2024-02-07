<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Forms\SettingForm;
use VitesseCms\Setting\SettingInterface;

class SettingText implements SettingInterface
{
    public function buildAdminForm(SettingForm $form): void
    {
        $form->addText('%ADMIN_VALUE%', 'value', (new Attributes())->setRequired()->setMultilang());
    }
}
