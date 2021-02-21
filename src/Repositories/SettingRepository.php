<?php declare(strict_types=1);

namespace VitesseCms\Setting\Repositories;

use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Setting\Models\Setting;

class SettingRepository
{
    public function findFirst(
        ?FindValueIterator $findValues = null,
        bool $hideUnpublished = true
    ): ?Setting
    {
        Setting::setFindPublished($hideUnpublished);
        $this->parsefindValues($findValues);

        /** @var Setting $datagroup */
        $datagroup = Setting::findFirst();
        if (is_object($datagroup)):
            return $datagroup;
        endif;

        return null;
    }

    protected function parsefindValues(?FindValueIterator $findValues = null): void
    {
        if ($findValues !== null) :
            while ($findValues->valid()) :
                $findValue = $findValues->current();
                Setting::setFindValue(
                    $findValue->getKey(),
                    $findValue->getValue(),
                    $findValue->getType()
                );
                $findValues->next();
            endwhile;
        endif;
    }
}