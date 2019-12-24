<?php

namespace Dtn\ProductLabel\Block\ProductLabel;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ListProduct;
use Dtn\ProductLabel\Model\LabelFactory;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;

class ProductLabel extends ListProduct
{
    protected $labelFactory;

    protected $date;

    public function __construct(
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        LabelFactory $labelFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        array $data = [])
    {
        $this->labelFactory = $labelFactory;
        $this->date = $date;
        $this->storeManager = $storeManager;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function getLabel()
    {
        $labels = $this->labelFactory->create()->getCollection()->addFieldToFilter('status',1);
        return $labels;
    }

    public function getUrlImage()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/tmp/category/';
    }

    public function getCurrentDate()
    {
        $date = $this->date->gmtDate();
        return $date;
    }
}