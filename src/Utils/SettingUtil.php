<?php declare(strict_types=1);

namespace VitesseCms\Setting\Utils;

use VitesseCms\Configuration\Services\ConfigService;
use VitesseCms\Core\Utils\DirectoryUtil;
use VitesseCms\Core\Utils\FileUtil;

class SettingUtil
{
    public static function getTypes(ConfigService $configService): array
    {
        $types = [[
            'value' => '',
            'label' => 'Choose a type',
            'selected' => false
        ]];

        $files = DirectoryUtil::getFilelist($configService->getVendorNameDir() . 'setting/src/Models/');
        foreach ($files as $path => $file) :
            $name = ucfirst(str_replace('Setting', '', FileUtil::getName($file)));
            if ($file !== 'Setting.php') :
                $types[] = [
                    'value' => FileUtil::getName($file),
                    'label' => strtolower($name),
                    'selected' => false
                ];
            endif;
        endforeach;

        return $types;
    }
}