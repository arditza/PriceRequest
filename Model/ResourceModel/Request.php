<?php

namespace Azra\PriceRequest\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 *
 */
class Request extends AbstractDb {

	/**
	 * Define table and primary key
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_init('azra_price_requests', 'entity_id');
	}
}
