<?php

namespace Dtn\ProductLabel\Controller\Adminhtml\Label;

use Dtn\ProductLabel\Model\LabelFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action  implements HttpPostActionInterface
{
    private $labelFactory;

    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        \Dtn\ProductLabel\Model\LabelFactory $labelFactory
    ) {
        $this->labelFactory = $labelFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $label = $this->labelFactory->create()->load($id);
        $label->delete();
        try {
            $this->messageManager->addSuccessMessage(__('You deleted the label.'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while delete the label.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');

    }
}