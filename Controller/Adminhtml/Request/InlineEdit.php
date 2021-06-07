<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Azra\PriceRequest\Controller\Adminhtml\Request;

use Azra\PriceRequest\Model\RequestFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class InlineEdit extends \Magento\Backend\App\Action {

	protected $jsonFactory;

	/**
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
	 */
	public function __construct(
		Context $context,
		JsonFactory $jsonFactory,
		RequestFactory $requestFactory
	) {
		parent::__construct($context);
		$this->jsonFactory = $jsonFactory;
		$this->requestFactory = $requestFactory;
	}

	/**
	 * Inline edit action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute() {
		/** @var \Magento\Framework\Controller\Result\Json $resultJson */
		$resultJson = $this->jsonFactory->create();
		$error = false;
		$messages = [];

		if ($this->getRequest()->getParam('isAjax')) {
			$postItems = $this->getRequest()->getParam('items', []);
			if (!count($postItems)) {
				$messages[] = __('Please correct the sent data.');
				$error = true;
			} else {
				foreach (array_keys($postItems) as $modelid) {
					/** @var \Azra\PriceRequest\Model\Request $model */
					$model = $this->requestFactory->create()->load($modelid);
					try {
						$model->setData(array_merge($model->getData(), $postItems[$modelid]));
						$model->save();
					} catch (\Exception $e) {
						$messages[] = "[Request ID: {$modelid}]  {$e->getMessage()}";
						$error = true;
					}
				}
			}
		}

		return $resultJson->setData([
			'messages' => $messages,
			'error' => $error,
		]);
	}
}
