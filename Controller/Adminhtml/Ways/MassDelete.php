<?php

namespace Make\Ship\Controller\Adminhtml\Ways;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Make\Ship\Model\ResourceModel\Ways\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{

    protected $filter;

    protected $collectionFactory;


    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
                
        $collectionSize = $collection->getSize();

        foreach ($collection as $ways) {
            $ways->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Make_Ship::ways_delete');
    }
}
