<?php
namespace Make\Ship\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Ways extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('make_ship', 'id');   //here "make_ship" is table name and "id" is the primary key of custom table
    }
}
