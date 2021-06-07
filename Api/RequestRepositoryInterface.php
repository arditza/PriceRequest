<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Azra\PriceRequest\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RequestRepositoryInterface {

	/**
	 * Save Request
	 * @param \Azra\PriceRequest\Api\Data\RequestInterface $request
	 * @return \Azra\PriceRequest\Api\Data\RequestInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function save(
		\Azra\PriceRequest\Api\Data\RequestInterface $request
	);

	/**
	 * Retrieve Request
	 * @param string $requestId
	 * @return \Azra\PriceRequest\Api\Data\RequestInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function get($requestId);

	/**
	 * Retrieve Request matching the specified criteria.
	 * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
	 * @return \Azra\PriceRequest\Api\Data\RequestSearchResultsInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getList(
		\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
	);

	/**
	 * Delete Request
	 * @param \Azra\PriceRequest\Api\Data\RequestInterface $request
	 * @return bool true on success
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function delete(
		\Azra\PriceRequest\Api\Data\RequestInterface $request
	);

	/**
	 * Delete Request by ID
	 * @param string $requestId
	 * @return bool true on success
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function deleteById($requestId);
}
