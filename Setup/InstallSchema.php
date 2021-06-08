<?php

namespace Azra\PriceRequest\Setup;

use Azra\PriceRequest\Model\Request\StatusProvider;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 */
class InstallSchema implements InstallSchemaInterface {

	/**
	 * @method install
	 * @param  SchemaSetupInterface   $setup
	 * @param  ModuleContextInterface $context
	 */
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$installer = $setup;
		$installer->startSetup();

		$table = $installer->getConnection()->newTable(
			$installer->getTable('azra_price_requests')
		)->addColumn(
			'entity_id',
			Table::TYPE_INTEGER,
			null,
			['identity' => true, 'nullable' => false, 'primary' => true],
			'Price Request Id'
		)->addColumn(
			'user_full_name',
			Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'User Full Name'
		)->addColumn(
			'email',
			Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'User Email'
		)->addColumn(
			'product_sku',
			Table::TYPE_TEXT,
			64,
			['nullable' => false],
			'Product Sku'
		)->addColumn(
			'comment',
			Table::TYPE_TEXT,
			'16k',
			['nullable' => false],
			'User price request comment'
		)->addColumn(
			'status',
			Table::TYPE_SMALLINT,
			2,
			['nullable' => false, "default" => StatusProvider::NEW_STATUS],
			'Price Request Status'
		)->addColumn(
			'store_id', // analityc purpose
			Table::TYPE_SMALLINT,
			null,
			['nullable' => false, "default" => 0],
			'Price Request Store Id'
		)->addColumn(
			'created_at',
			Table::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
			'Created At'
		)->addColumn(
			'updated_at',
			Table::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
			'Updated At'
		)->addIndex(
			$installer->getIdxName('azra_price_requests', ['email']),
			['email']
		)->addIndex(
			$installer->getIdxName('azra_price_requests', ['product_sku']),
			['product_sku']
		)->addIndex(
			$installer->getIdxName('azra_price_requests', ['status']),
			['status']
		);
		$installer->getConnection()->createTable($table);

		$installer->endSetup();
	}
}
