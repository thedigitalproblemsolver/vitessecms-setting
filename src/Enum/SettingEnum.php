<?php declare(strict_types=1);

namespace VitesseCms\Setting\Enum;

enum SettingEnum: string
{
    case SERVICE_LISTENER = 'settingService';
    case ATTACH_SERVICE_LISTENER = 'settingService:attach';
}