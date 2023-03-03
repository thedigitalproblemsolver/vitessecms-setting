<?php declare(strict_types=1);

namespace VitesseCms\Setting\Forms;

use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Setting\Enum\TypeEnum;
use VitesseCms\Setting\Models\Setting;

class SettingForm extends AbstractFormWithRepository
{
    /**
     * @var Setting
     */
    protected $entity;

    public function buildForm(): FormWithRepositoryInterface
    {
        if ($this->entity === null) :
            $this->entity = new Setting();
        endif;

        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired()->setMultilang());

        $readonly = false;
        if ($this->entity->getCallingName() !== null) :
            $readonly = true;
        endif;

        $this->addText(
            '%ADMIN_CALLING_NAME%',
            'calling_name',
            (new Attributes())->setRequired()->setReadonly($readonly)
        );
        
        if ($this->entity->getType() === null) :
            $this->addDropdown(
                '%ADMIN_TYPE%',
                'type',
                (new Attributes())->setRequired(true)
                    ->setOptions(ElementHelper::arrayToSelectOptions(TypeEnum::ALL_TYPES))
            );
        else :
            $object = $this->entity->getTypeClass();
            /** @var SettingInterface $object */
            $object = new $object();
            $object->buildAdminForm($this, $this->entity);
        endif;

        $this->addSubmitButton('%CORE_SAVE%');

        return $this;
    }
}
