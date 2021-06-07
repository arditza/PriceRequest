<?php

namespace Azra\PriceRequest\Block\Price;

use Azra\PriceRequest\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

/**
 *
 */
class Request extends Template {

	/**
	 * @var Session
	 */
	protected $_customerSession;

	/**
	 * @var Product
	 */
	protected $_product = null;

	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $_coreRegistry = null;

	/**
	 * @param Data             $helper
	 * @param Registry         $registry
	 * @param Template\Context $context
	 * @param array            $data
	 */
	public function __construct(
		Data $helper,
		Registry $registry,
		Session $customerSession,
		Template\Context $context,
		array $data = []
	) {
		$this->_dataHelper = $helper;
		$this->_coreRegistry = $registry;
		$this->_customerSession = $customerSession;

		parent::__construct($context, $data);
	}

	/**
	 * @return Product
	 */
	public function getProduct() {
		if (!$this->_product) {
			$this->_product = $this->_coreRegistry->registry('product');
		}
		return $this->_product;
	}

	/**
	 * checks if price request functionality is enabled
	 *
	 * @return boolean
	 */
	public function isEnabled() {
		return $this->_dataHelper->isEnabled();
	}

	/**
	 * Returns action url for price request form
	 *
	 * @return string
	 */
	public function getFormAction() {
		return $this->getUrl('price/request/post', ['_secure' => true]);
	}

	/**
	 * returns customer fullname if it is logged in
	 * @return string
	 */
	public function getCustomerName() {
		if (!$this->_customerSession->isLoggedIn()) {
			return "";
		}
		$customer = $this->_customerSession->getCustomer();
		return $customer->getName() . " " . $customer->getLastName();
	}

	/**
	 * returns customer email if it is logged in
	 * @return string
	 */
	public function getCustomerEmail() {
		if (!$this->_customerSession->isLoggedIn()) {
			return "";
		}
		return $this->_customerSession->getCustomer()->getEmail();
	}
}
