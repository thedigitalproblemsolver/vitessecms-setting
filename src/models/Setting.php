<?php declare(strict_types=1);

namespace VitesseCms\Setting\Models;

use VitesseCms\Database\AbstractCollection;
use VitesseCms\Core\Services\CacheService;
use Phalcon\Di;

class Setting extends AbstractCollection
{
    /**
     * @var array
     */
    public $value;

    /**
     * @var string
     */
    public $calling_name;

    /**
     * @var string
     */
    public $type;

    public function initialize()
    {
        $this->value = [];
    }

    public function getValues(): array
    {
        return (array)$this->value??[];
    }

    public function getValueField(): ?string
    {
        return $this->_('value');
    }

    public function getCallingName(): ?string
    {
        return $this->calling_name;
    }

    public function setCallingName(string $calling_name): Setting
    {
        $this->calling_name = $calling_name;

        return $this;
    }

    public function setType(string $type): Setting
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getTypeClass(): string
    {
        return '\\VitesseCms\\Setting\\Models\\Setting'.str_replace('Setting','', ucfirst($this->type));
    }

    //TODO move to listener
    public function afterSave()
    {
        /** @var CacheService $cache */
        $cache = Di::getDefault()->get('cache');
        foreach ($this->getValues() as $languageShort => $value):
            $cache->delete(
                $cache->getCacheKey($this->getCallingName().$languageShort)
            );
        endforeach;
    }
}
