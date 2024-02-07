<?php

declare(strict_types=1);

namespace VitesseCms\Setting\Services;

use VitesseCms\Configuration\Services\ConfigService;
use VitesseCms\Core\Services\CacheService;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Setting\Factory\SettingFactory;
use VitesseCms\Setting\Repositories\SettingRepository;

class SettingService
{
    public function __construct(
        private readonly CacheService $cache,
        private readonly ConfigService $configuration,
        private readonly SettingRepository $settingRepository
    ) {
    }

    public function has(string $settingKey, bool $hideUnpublished = true): bool
    {
        $settingKey = $this->buildCallingName($settingKey);

        $content = $this->cache->get($this->cache->getCacheKey($settingKey));
        if (null !== $content) {
            return true;
        }

        $setting = $this->settingRepository->findFirst(
            new FindValueIterator([new FindValue('calling_name', $settingKey)]),
            $hideUnpublished
        );

        if (null !== $setting) {
            return true;
        }

        return false;
    }

    protected function buildCallingName(string $setting): string
    {
        return strtoupper(str_replace([' ', '-'], '_', $setting));
    }

    public function get(string $settingKey, bool $showUnPublished = true)
    {
        $settingKey = $this->buildCallingName($settingKey);
        $cacheKey = $this->cache->getCacheKey($settingKey.$this->configuration->getLanguageShort());
        $content = $this->cache->get($cacheKey);

        if (!$content) {
            $setting = $this->settingRepository->findFirst(
                new FindValueIterator([new FindValue('calling_name', $settingKey)])
            );
            if (null === $setting && $showUnPublished) {
                $setting = $this->settingRepository->findFirst(
                    new FindValueIterator([new FindValue('calling_name', $settingKey)]),
                    false
                );
                if (null === $setting) {
                    SettingFactory::create($settingKey)->save();

                    return '';
                } else {
                    $content = $setting->getValueField();
                    $this->cache->save($cacheKey, $content);
                }
            } elseif (null !== $setting) {
                $content = $setting->getValueField();
                $this->cache->save($cacheKey, $content);
            }
        }

        return $content;
    }

    public function getRaw(string $settingKey): array
    {
        $setting = $this->settingRepository->findFirst(
            new FindValueIterator([new FindValue('calling_name', $settingKey)]),
            false
        );

        if (null === $setting) {
            return [];
        }

        return $setting->getValues();
    }

    public function parsePlaceholders(string $content): string
    {
        foreach ($this->getSettingsFromString($content) as $key => $value) {
            $content = str_replace(
                ['{{{'.$value.'}}}', '{{'.$value.'}}'],
                $this->get($value),
                $content
            );
        }

        return $content;
    }

    public function getSettingsFromString(string $string): array
    {
        $return = [];

        preg_match_all('/{{([A-Z_-]*)}}/', $string, $aMatches);
        foreach ($aMatches[1] as $key => $value) {
            if (2 === substr_count($value, '_')) {
                $return[] = $value;
            }
        }

        return $return;
    }

    public function getString(string $settingKey): string
    {
        return (string) $this->get($settingKey, false);
    }

    public function getBool(string $settingKey): bool
    {
        return (bool) $this->get($settingKey, false);
    }
}
