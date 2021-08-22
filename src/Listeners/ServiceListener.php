<?php declare(strict_types=1);

namespace VitesseCms\Setting\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Configuration\Services\ConfigService;
use VitesseCms\Core\Services\CacheService;
use VitesseCms\Setting\Repositories\SettingRepository;
use VitesseCms\Setting\Services\SettingService;

class ServiceListener
{
    /**
     * @var CacheService
     */
    private $cache;

    /**
     * @var ConfigService
     */
    private $configuration;

    /**
     * @var SettingRepository
     */
    private $repository;

    public function __construct(
        CacheService $cache,
        ConfigService $configuration,
        SettingRepository $settingRepository
    ) {
        $this->cache = $cache;
        $this->configuration = $configuration;
        $this->repository = $settingRepository;
    }

    public function attach( Event $event): SettingService
    {
        return new SettingService($this->cache, $this->configuration, $this->repository);
    }
}
