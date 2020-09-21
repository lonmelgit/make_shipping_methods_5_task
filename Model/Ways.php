<?php

namespace Make\Ship\Model;

use Make\Ship\Api\Data\WaysInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Ways extends AbstractModel implements WaysInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;


    protected function _construct()
    {
        $this->_init('Make\Ship\Model\ResourceModel\Ways');
    }

    public function getIdentities()
    {
        return [$this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getId()
    {
        return parent::getData(self::ID);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }


    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }


    public function getMinSubtotal()
    {
        return $this->getData(self::MIN_SUBTOTAL);
    }

    public function getMaxSubtotal()
    {
        return $this->getData(self::MAX_SUBTOTAL);
    }

    public function getMinWeight()
    {
        return $this->getData(self::MIN_WEIGHT);
    }

    public function getMaxWeight()
    {
        return $this->getData(self::MAX_WEIGHT);
    }

    public function getZipcode()
    {
        return $this->getData(self::ZIPCODE);
    }

    public function getPercent()
    {
        return $this->getData(self::PERCENT);
    }


    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    public function setMinSubtotal($min_subtotal)
    {
        return $this->setData(self::MIN_SUBTOTAL, $min_subtotal);
    }

    public function setMaxSubtotal($max_subtotal)
    {
        return $this->setData(self::MAX_SUBTOTAL, $max_subtotal);
    }

    public function setMinWeight($min_weight)
    {
        return $this->setData(self::MIN_WEIGHT, $min_weight);
    }

    public function setMaxWeight($max_weight)
    {
        return $this->setData(self::MAX_WEIGHT, $max_weight);
    }

    public function setZipcode($zipcode)
    {
        return $this->setData(self::ZIPCODE, $zipcode);
    }

    public function setPercent($percent)
    {
        return $this->setData(self::PERCENT, $percent);
    }
}
