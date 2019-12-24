<?php

namespace Dtn\ProductLabel\Model\ResourceModel\Label;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Dtn\ProductLabel\Model\Label','Dtn\ProductLabel\Model\ResourceModel\Label');
    }
}