<?php

declare(strict_types=1);

namespace Strekoza\SeoSettings\Observer;

use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;

/**
 * @since 1.0.0
 */
class ChangeMetaForFilters implements ObserverInterface
{
    private Layer $catalogLayer;
    private PageConfig $pageConfig;

    /**
     * @param PageConfig $pageConfig
     * @param Resolver $layerResolver
     */
    public function __construct(
        PageConfig $pageConfig,
        Resolver   $layerResolver
    )
    {
        $this->catalogLayer = $layerResolver->get();
        $this->pageConfig = $pageConfig;
    }

    /**
     * Changing attribute values
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$this->catalogLayer->getState()->getFilters()) {
            return;
        }

        $this->setRobots();
    }

    /**
     * Set robots to page with active filters.
     *
     * @return void
     */
    public function setRobots(): void
    {
        $this->pageConfig->setRobots('NOINDEX,NOFOLLOW');
    }

}
