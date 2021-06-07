<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Azra\PriceRequest\Api\Data;

interface RequestInterface extends \Magento\Framework\Api\ExtensibleDataInterface {

	const REQUEST_ID = 'entity_id';

	/**
	 * Get request_id
	 * @return string|null
	 */
	public function getRequestId();

	/**
	 * Set request_id
	 * @param string $requestId
	 * @return \Azra\PriceRequest\Api\Data\RequestInterface
	 */
	public function setRequestId($requestId);
}
