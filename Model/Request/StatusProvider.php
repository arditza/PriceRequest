<?php

namespace Azra\PriceRequest\Model\Request;

use \Magento\Framework\Option\ArrayInterface;

/**
 *
 */
class StatusProvider implements ArrayInterface {

	const NEW_STATUS = 1;
	const IN_PROGRESS_STATUS = 2;
	const CLOSED_STATUS = 3;

	/**
	 * Retrieve options array.
	 *
	 * @return array
	 */
	public function toOptionArray() {
		$result = [];

		foreach (self::getOptionArray() as $index => $value) {
			$result[] = ['value' => $index, 'label' => $value];
		}

		return $result;
	}

	/**
	 * Retrieve option array
	 *
	 * @return string[]
	 */
	public static function getOptionArray() {
		return [
			self::NEW_STATUS => __('New'),
			self::IN_PROGRESS_STATUS => __('In Progress'),
			self::CLOSED_STATUS => __('Closed'),
		];
	}

	/**
	 * Retrieve option array with empty value
	 *
	 * @return string[]
	 */
	public function getAllOptions() {
		return $this->toOptionArray();
	}

	/**
	 * Retrieve option text by option value
	 *
	 * @param string $optionId
	 * @return string
	 */
	public function getOptionText($optionId) {
		$options = self::getOptionArray();

		return isset($options[$optionId]) ? $options[$optionId] : null;
	}
}
