<?php

namespace Azra\PriceRequest\Model;

use Magento\Framework\Model\AbstractModel;

/**
 *
 */
class Request extends AbstractModel {

	/**
	 * Define resource model
	 */
	protected function _construct() {
		$this->_init(\Azra\PriceRequest\Model\ResourceModel\Request::class);
	}
}
