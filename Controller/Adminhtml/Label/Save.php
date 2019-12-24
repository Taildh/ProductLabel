<?php

namespace Dtn\ProductLabel\Controller\Adminhtml\Label;

use Dtn\ProductLabel\Model\LabelFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Dtn\ProductLabel\Model\Uploader;
use Dtn\ProductLabel\Model\UploaderPool;

class Save extends \Magento\Backend\App\Action  implements HttpPostActionInterface
{
    private $labelFactory;

    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Dtn\ProductLabel\Model\LabelFactory $labelFactory
    ) {
        $this->labelFactory = $labelFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        $data = $this->getRequest()->getPostValue();
        $data = $this->_filterFoodData($data);
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        if ($id)
        {
            $model = $this->labelFactory->create()->load($id);
        } else {
            $model = $this->labelFactory->create();
        }
        $model->setName($data['name'])
                ->setImage($data['image'])
                ->setStatus($data['status'])
                ->setWidth($data['width'])
                ->setHeight($data['height'])
                ->setFont_size($data['font_size'])
                ->setColor($data['color'])
                ->setLabel_text($data['label_text'])
                ->save();
        return $resultRedirect->setPath('*/*/');
    }

    public function _filterFoodData(array $rawData)
    {
        //Replace image with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
}