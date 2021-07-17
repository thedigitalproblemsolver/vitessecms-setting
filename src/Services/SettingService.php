<?php declare(strict_types=1);

namespace VitesseCms\Setting\Services;

use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Setting\Models\Setting;
use VitesseCms\Core\Services\CacheService;
use VitesseCms\Configuration\Services\ConfigService;
use VitesseCms\Setting\Factory\SettingFactory;
use VitesseCms\Setting\Repositories\SettingRepository;

class SettingService
{
    /**
     * @var CacheService
     */
    protected $cache;

    /**
     * @var ConfigService
     */
    protected $configuration;

    protected $settingRepository;

    public function __construct(
        CacheService $cache,
        ConfigService $configuration,
        SettingRepository $settingRepository
    )
    {
        $this->cache = $cache;
        $this->configuration = $configuration;
        $this->settingRepository = $settingRepository;
    }

    public function has(string $setting, $hideUnpublished = true): bool
    {
        $setting = $this->buildCallingName($setting);
        $content = $this->cache->get($this->cache->getCacheKey($setting));
        if ($content !== null) :
            return true;
        endif;

        $setting = $this->settingRepository->findFirst(
            new FindValueIterator([new FindValue('calling_name', $setting)]),
            $hideUnpublished
        );
        if ($setting !== null) :
            return true;
        endif;

        return false;
    }

    protected function buildCallingName(string $setting): string
    {
        return strtoupper(str_replace([' ', '-'], '_', $setting));
    }

    public function parsePlaceholders(string $content): string
    {
        preg_match_all('/{{([A-Z_-]*)}}/', $content, $aMatches);
        foreach ((array)$aMatches[1] as $key => $value) :
            if (substr_count($value, '_') === 2) :
                $content = str_replace(
                    ['{{{' . $value . '}}}', '{{' . $value . '}}'],
                    $this->get($value),
                    $content
                );
            endif;
        endforeach;

        return $content;
    }

    public function get(string $settingKey)
    {
        $settingKey = $this->buildCallingName($settingKey);
        $cacheKey = $this->cache->getCacheKey($settingKey . $this->configuration->getLanguageShort());
        $content = $this->cache->get($cacheKey);
        if (!$content) :
            $setting = $this->settingRepository->findFirst(
                new FindValueIterator([new FindValue('calling_name', $settingKey)])
            );
            if ($setting === null) :
                $setting = $this->settingRepository->findFirst(
                    new FindValueIterator([new FindValue('calling_name', $settingKey)]),
                    false
                );
                if ($setting === null) :
                    SettingFactory::create($settingKey)->save();

                    return '';
                else :
                    $content = $setting->getValueField();
                    $this->cache->save($cacheKey, $content);
                endif;
            else :
                $content = $setting->getValueField();
                $this->cache->save($cacheKey, $content);
            endif;
        endif;

        return $content;
    }

    public function getString(string $settingKey): string
    {
        return (string)$this->get($settingKey);
    }

    public function getBool(string $settingKey): bool
    {
        return (bool)$this->get($settingKey);
    }
}
