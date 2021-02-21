<?php declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\SettingInterface;
use VitesseCms\Setting\Forms\SettingForm;

class SettingTextEditor implements SettingInterface
{
    public function buildAdminForm(SettingForm $form, Setting $item)
    {
        $form->addEditor('%CORE_VALUE%', 'value', (new Attributes())->setRequired()->setMultilang());
    }
}
