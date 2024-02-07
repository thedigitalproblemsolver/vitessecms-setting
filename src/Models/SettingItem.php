<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Content\Enum\ItemEnum;
use VitesseCms\Core\Helpers\ItemHelper;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Forms\SettingForm;
use VitesseCms\Setting\SettingInterface;

class SettingItem implements SettingInterface
{
    public function buildAdminForm(SettingForm $form): void
    {
        $itemRepository = $form->eventsManager->fire(ItemEnum::GET_REPOSITORY, new \stdClass());

        $options = [];
        if (null !== $form->getEntity()->getValueField()) {
            $selectedItem = $itemRepository->getById($form->getEntity()->getValueField());
            if (null !== $selectedItem) {
                $itemPath = ItemHelper::getPathFromRoot($selectedItem);
                $options[(string) $selectedItem->getId()] = implode(' - ', $itemPath);
            }
        }

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
