<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Forms;

use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Enum\TypeEnum;
use VitesseCms\Setting\Models\Setting;
use VitesseCms\Setting\SettingInterface;

class SettingForm extends AbstractFormWithRepository
{
    /**
     * @var Setting
     */
    protected $entity;

    public function buildForm(): FormWithRepositoryInterface
    {
        if (null === $this->entity) {
            $this->entity = new Setting();
        }

        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired()->setMultilang());

        $readonly = false;
        if (null !== $this->entity->getCallingName()) {
            $readonly = true;
        }

        $this->addText(
            '%ADMIN_CALLING_NAME%',
            'calling_name',
            (new Attributes())->setRequired()->setReadonly($readonly)
        );

        if (null === $this->entity->getType()) {
            $this->addDropdown(
                '%ADMIN_TYPE%',
                'type',
                (new Attributes())->setRequired(true)
                    ->setOptions(ElementHelper::arrayToSelectOptions(TypeEnum::ALL_TYPES))
            );
        } else {
            $object = $this->entity->getTypeClass();
            /** @var SettingInterface $object */
            $object = new $object();
            $object->buildAdminForm($this);
        }

        $this->addSubmitButton('%CORE_SAVE%');

        return $this;
    }
}
