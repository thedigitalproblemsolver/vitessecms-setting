<?php

declare(strict_types=1);

namespace VitesseCms\Setting;

use VitesseCms\Setting\Forms\SettingForm;

interface SettingInterface
{
    public function buildAdminForm(SettingForm $form): void;
}
