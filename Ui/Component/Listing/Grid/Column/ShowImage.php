<?php
namespace Dtn\ProductLabel\Ui\Component\Listing\Grid\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ShowImage extends Column
{
    const NAME = 'image';
    const ALT_FIELD = 'name';
    const IMAGEPATCH = 'catalog/tmp/category/';
    protected $storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    $item[$fieldName . '_src'] = $path.self::IMAGEPATCH.$item['image'];
                    $item[$fieldName . '_orig_src'] = $path.self::IMAGEPATCH.$item['image'];
                }else{
                    echo "Please upload the image!";
                }
            }
        }
        return $dataSource;
    }
}