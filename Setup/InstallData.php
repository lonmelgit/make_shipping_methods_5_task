<?php

namespace Make\Ship\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $date;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->date = $date;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $dataWaysRows = [
            [
                'name' => 'Small shipping method',
                'status' => 1,
                'price' => '3.50',
                'min_subtotal' => '0.00',
                'max_subtotal' => '50.00',
                'min_weight' => '0.00',
                'max_weight' => '5.00',
                'percent' => '5.00'

            ],
            [
                'name' => 'Second shipping method',
                'status' => 1,
                'price' => '7.00',
                'min_subtotal' => '0.00',
                'max_subtotal' => '150.00',
                'min_weight' => '0.00',
                'max_weight' => '10.00',
                'percent' => '7.00'
            ],
            [
                'name' => 'Third shipping method',
                'status' => 1,
                'price' => '2.00',
                'min_subtotal' => '100.00',
                'max_subtotal' => '300.00',
                'min_weight' => '0.00',
                'max_weight' => '20.00',
                'percent' => '10.00'
            ]
        ];

        foreach ($dataWaysRows as $data) {
            $setup->getConnection()->insert($setup->getTable('make_ship'), $data);
        }
    }
}
