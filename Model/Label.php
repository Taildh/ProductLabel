<?php

namespace Dtn\ProductLabel\Model;

class Label extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Dtn\ProductLabel\Model\ResourceModel\Label');
    }
}