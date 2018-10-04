<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Test\Weather\Api\Data\WeatherInterface;

/**
 * Class InstallSchema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = $setup->getTable(WeatherInterface::TABLE);

        if (!$setup->getConnection()->isTableExists($tableName)) {
            $table = $setup->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    WeatherInterface::ID,
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    WeatherInterface::FIELD_WEATHER,
                    Table::TYPE_TEXT,
                    null,
                    ['nullable'=>false],
                    'Weather'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default' => Table::TIMESTAMP_INIT
                    ],
                    'Created At'
                )
                ->setComment('Test Weather');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
