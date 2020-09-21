<?php
namespace Make\Ship\Model\Ways;

use Make\Ship\Model\ResourceModel\Ways\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $waysCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $waysCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }


    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $ways) {
            $this->loadedData[$ways->getId()] = $ways->getData();
        }

        $data = $this->dataPersistor->get('ship_ways'); // check how it implemented in another data providers in M2
        if (!empty($data)) {
            $ways = $this->collection->getNewEmptyItem();
            $ways->setData($data);
            $this->loadedData[$ways->getId()] = $ways->getData();
            $this->dataPersistor->clear('ship_ways');
        }

        return $this->loadedData;
    }
}
