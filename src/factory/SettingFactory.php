<?php declare(strict_types=1);

namespace VitesseCms\Setting\Factory;

use VitesseCms\Setting\Models\Setting;

class SettingFactory
{
    public static function create(
        string $calling_name,
        string $type,
        string $value = '',
        string $name = '',
        bool $published = false
    ): Setting {
        if(empty($name)) :
            $name = ucwords(str_replace('_',' - ',$calling_name));
        endif;

        $setting = new Setting();
        $setting->set('name', $name, true);
        $setting->setCallingName($calling_name);
        $setting->setPublished($published);
        $setting->setType($type);
        $setting->set('value', $value, true);

        return $setting;
    }
}
