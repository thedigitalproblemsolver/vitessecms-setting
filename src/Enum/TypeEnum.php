<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Enum;

use VitesseCms\Core\AbstractEnum;

class TypeEnum extends AbstractEnum
{
    public const BLOCK = 'SettingBlock';
    public const COLOR = 'SettingColor';
    public const DATAGROUP = 'SettingDatagroup';
    public const IMAGE = 'SettingImage';
    public const ITEM = 'SettingItem';
    public const TEXT = 'SettingText';
    public const TEXTAREA = 'SettingTextArea';
    public const TEXT_EDITOR = 'SettingTextEditor';

    public const ALL_TYPES = [
        self::BLOCK => 'Block',
        self::COLOR => 'Color',
        self::DATAGROUP => 'Datagroup',
        self::IMAGE => 'Image',
        self::ITEM => 'Item',
        self::TEXT => 'Text',
        self::TEXTAREA => 'Textarea',
        self::TEXT_EDITOR => 'Text editor',
    ];
}
