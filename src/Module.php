<?php

declare(strict_types=1);

namespace VitesseCms\Setting;

use Phalcon\Di\DiInterface;
use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Block\Models\Block;
use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Core\AbstractModule;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Setting\Repositories\AdminRepositoryCollection;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Setting');

        if (AdminUtil::isAdminPage()) :
            $di->setShared(
                'repositories',
                new AdminRepositoryCollection(
                    new BlockRepository(Block::class),
                    new DatagroupRepository(),
                    new ItemRepository()
                )
            );
        endif;
    }
}
