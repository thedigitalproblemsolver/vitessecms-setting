<?php declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Helpers\ItemHelper;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\SettingInterface;
use VitesseCms\Setting\Forms\SettingForm;

class SettingItem implements SettingInterface
{
    public function buildAdminForm(SettingForm $form, Setting $item) {
        $options = [];
        if($item->getValueField() !== null) :
            $selectedItem = $form->repositories->item->getById($item->getValueField());
            if($selectedItem !== null) :
                $itemPath = ItemHelper::getPathFromRoot($selectedItem);
                $options[(string)$selectedItem->getId()] = implode(' - ', $itemPath);
            endif;
        endif;

        $form->addDropdown(
            '%ADMIN_VALUE%',
            'value',
            (new Attributes())
                ->setInputClass('select2-ajax')
                ->setDataUrl('/content/index/search/')
                ->setOptions(ElementHelper::arrayToSelectOptions($options))
        );
    }
}
