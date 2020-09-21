<?php

namespace Make\Ship\Controller\Adminhtml\Ways;

use Magento\Backend\App\Action;
use Make\Ship\Model\Ways;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    private $waysFactory;

    private $waysRepository;


    public function __construct(
        \Magento\Backend\Model\Auth\Session $authSession,
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Make\Ship\Model\WaysFactory $waysFactory = null,
        \Make\Ship\Api\WaysRepositoryInterface $waysRepository = null
    ) {
        $this->authSession = $authSession;
        $this->dataPersistor = $dataPersistor;
        $this->waysFactory = $waysFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Make\Ship\Model\WaysFactory::class);
        $this->waysRepository = $waysRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Make\Ship\Api\WaysRepositoryInterface::class);
        parent::__construct($context);
    }


    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Ways::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->waysRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This method no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model = $this->waysFactory->create();

            $model->setData($data);

            $this->_eventManager->dispatch(
                'ship_ways_prepare_save',
                ['ways' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->waysRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the method.'));
                $this->dataPersistor->clear('ship_ways');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the method.'));
            }

            $this->dataPersistor->set('ship_ways', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Make_Ship::save');
    }
}
