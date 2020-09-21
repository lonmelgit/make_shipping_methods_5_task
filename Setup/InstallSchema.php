<?php
namespace Make\Ship\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $conn = $setup->getConnection();
        $tableName = $setup->getTable('make_ship');
        if ($conn->isTableExists($tableName) != true) {
            $table = $conn->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity'=>true,'unsigned'=>true,'nullable'=>false,'primary'=>true]
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable'=>false,'default'=>'']
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'unsigned' => true],
                    'Status'
                )
                ->addColumn(
                    'price',
                    Table::TYPE_DECIMAL,
                    '10,2',
                    ['nullable' => false, 'unsigned'=>true,'default' => '0.00'],
                    'Decimal'
                )
                ->addColumn(
                    'min_subtotal',
                    Table::TYPE_DECIMAL,
                    '10,2',
                    ['nullable' => false, 'unsigned'=>true,'default' => '0.00'],
                    'Decimal'
                )
                ->addColumn(
                    'max_subtotal',
                    Table::TYPE_DECIMAL,
                    '10,2',
                    ['nullable' => false, 'unsigned'=>true,'default' => '0.00'],
                    'Decimal'
                )
                ->addColumn(
                    'min_weight',
                    Table::TYPE_DECIMAL,
                    '10,2',
                    ['nullable' => false, 'unsigned'=>true,'default' => '0.00'],
                    'Decimal'
                )
                ->addColumn(
                    'max_weight',
                    Table::TYPE_DECIMAL,
                    '10,2',
                    ['nullable' => false, 'unsigned'=>true,'default' => '0.00'],
                    'Decimal'
                )
                ->addColumn(
                    'zipcode',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned'=>true,'nullable'=>false]
                )
                ->addColumn(
                    'percent',
                    Table::TYPE_DECIMAL,
                    '10,2',
                    ['nullable' => false, 'unsigned'=>true,'default' => '0.00'],
                    'Decimal'
                )
                ->addIndex(
                    $setup->getIdxName('make_ship', ['name']),
                    ['name']
                )
                ->setOption('charset', 'utf8');
            $conn->createTable($table);
        }
        $setup->endSetup();
    }
}
