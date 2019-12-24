<?php

namespace Dtn\ProductLabel\Model\Label;

use Dtn\ProductLabel\Model\ResourceModel\Label\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;

/**
 * Class DataProvider
 */

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    private $auth;

    private $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $labelCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null
        
    ) {
        $this->collection = $labelCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $label) {
            $this->loadedData[$label->getId()] = $label->getData();
            if ($label->getImage()) {
                $m['image'][0]['name'] = $label->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$label->getImage();
                $fullData = $this->loadedData;
                $this->loadedData[$label->getId()] = array_merge($fullData[$label->getId()], $m);
            }
        }
        $data = $this->dataPersistor->get('dtn_productlabel_label');
        if (!empty($data)) {
            $label = $this->collection->getNewEmptyItem();
            $label->setData($data);
            $this->loadedData[$label->getId()] = $label->getData();
            $this->dataPersistor->clear('dtn_productlabel_label');
        }

        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        if (!$this->auth->isAllowed('Dtn_ProductLabel::label')) {
            $designMeta = [
                'design' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true
                            ]
                        ]
                    ]
                ],
                'custom_design_update' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true
                            ]
                        ]
                    ]
                ]
            ];
            $meta = array_merge_recursive($meta, $designMeta);
        }

        return $meta;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/tmp/category/';
        return $mediaUrl;
    }

}
