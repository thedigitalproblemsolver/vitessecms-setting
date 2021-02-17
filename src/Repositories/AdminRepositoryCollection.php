<?php declare(strict_types=1);

namespace VitesseCms\Setting\Repositories;

use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Database\Interfaces\BaseRepositoriesInterface;
use VitesseCms\Language\Repositories\LanguageRepository;

class AdminRepositoryCollection implements BaseRepositoriesInterface
{
    /**
     * @var BlockRepository
     */
    public $block;

    /**
     * @var DatagroupRepository
     */
    public $datagroup;

    /**
     * @var ItemRepository
     */
    public $item;

    public function __construct(
        BlockRepository $blockRepository,
        DatagroupRepository $datagroupRepository,
        ItemRepository $itemRepository
    ) {
        $this->block = $blockRepository;
        $this->datagroup = $datagroupRepository;
        $this->item = $itemRepository;
    }
}
