<?php

namespace Dtn\ProductLabel\Model\ImageLabel;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Image extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    protected $subDir = 'catalog/category';

    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder
    )
    {
        $this->urlBuilder = $urlBuilder;
    }

    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$this->subDir;
    }

    public function isTmpFileAvailable($value)
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }
}