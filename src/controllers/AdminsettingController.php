<?php declare(strict_types=1);

namespace VitesseCms\Setting\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Setting\Forms\SettingForm;
use VitesseCms\Setting\Models\Setting;
use VitesseCms\Setting\Repositories\AdminRepositoriesInterface;

class AdminsettingController extends AbstractAdminController implements AdminRepositoriesInterface
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Setting::class;
        $this->classForm = SettingForm::class;
    }
}
