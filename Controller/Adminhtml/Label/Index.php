<?php

namespace Dtn\ProductLabel\Controller\Adminhtml\Label;

class Index extends \Dtn\ProductLabel\Controller\Adminhtml\Label
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Label Products Manager'));
        return $resultPage;

    }
}