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

	/**
	 * handle model data before save
	 * @return $this
	 */
	public function beforeSave() {
		if ($this->hasDataChanges()) {
			$this->setData("updated_at", null);
		}
		return parent::beforeSave();
	}
}
