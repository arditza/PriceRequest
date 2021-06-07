<?php

namespace Azra\PriceRequest\Model\ResourceModel\Request;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 *
 */
class Collection extends AbstractCollection {

	/**
	 * @var string
	 */
	protected $_idFieldName = 'entity_id';

	/**
	 * Define model and resource model
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_init(
			\Azra\PriceRequest\Model\Request::class,
			\Azra\PriceRequest\Model\ResourceModel\Request::class
		);
	}
}
