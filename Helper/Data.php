<?php

namespace Azra\PriceRequest\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 *
 */
class Data extends AbstractHelper {

	const ENABLED_XML_PATH = 'price_request/general/enable';

	/**
	 * retrieve admin configuration value
	 *
	 * @param  string $field
	 * @param  string $storeId
	 * @return mixed
	 */
	public function getConfigValue($field, $storeId = null) {
		return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
	}

	/**
	 * checks if product price functionality is enabled
	 *
	 * @return boolean
	 */
	public function isEnabled() {
		return $this->getConfigValue(self::ENABLED_XML_PATH);
	}
}
