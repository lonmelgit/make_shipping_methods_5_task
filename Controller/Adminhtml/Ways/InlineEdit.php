<?php
namespace Make\Ship\Controller\Adminhtml\Ways;

use Magento\Backend\App\Action\Context;
use Make\Ship\Api\WaysRepositoryInterface as WaysRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Make\Ship\Api\Data\WaysInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $waysRepository;

    protected $jsonFactory;

    public function __construct(
        Context $context,
        WaysRepository $waysRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->waysRepository = $waysRepository;
        $this->jsonFactory = $jsonFactory;
    }


    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $waysId) {
            $ways = $this->waysRepository->getById($waysId);
            try {
                $waysData = $postItems[$waysId];
                $extendedWaysData = $ways->getData();
                $this->setWaysData($ways, $extendedWaysData, $waysData);
                $this->waysRepository->save($ways);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithWaysId($ways, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithWaysId($ways, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithWaysId(
                    $ways,
                    __('Something went wrong while saving the new method.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Make_Ship::save');
    }

    protected function getErrorWithWaysId(WaysInterface $ways, $errorText)
    {
        return '[Method ID: ' . $ways->getId() . '] ' . $errorText;
    }

    public function setWaysData(\Make\Ship\Model\Ways $ways, array $extendedWaysData, array $waysData)
    {
        $ways->setData(array_merge($ways->getData(), $extendedWaysData, $waysData));
        return $this;
    }
}
