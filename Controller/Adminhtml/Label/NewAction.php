<?php

namespace Dtn\ProductLabel\Controller\Adminhtml\Label;

use Dtn\ProductLabel\Controller\Adminhtml\Label;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Label
{
    public function execute()
    {
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward->forward('edit');
    }
}