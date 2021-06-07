<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Azra\PriceRequest\Controller\Adminhtml\Request;

use Azra\PriceRequest\Model\RequestFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

class Delete extends \Azra\PriceRequest\Controller\Adminhtml\Request {

	/**
	 * @param Context        $context
	 * @param Registry       $coreRegistry
	 * @param RequestFactory $requestFactory
	 */
	public function __construct(
		Context $context,
		Registry $coreRegistry,
		RequestFactory $requestFactory
	) {
		$this->_coreRegistry = $coreRegistry;
		$this->requestFactory = $requestFactory;

		parent::__construct($context, $coreRegistry);
	}

	/**
	 * Delete action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute() {
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();
		// check if we know what should be deleted
		$id = $this->getRequest()->getParam('request_id');
		if ($id) {
			try {
				// init model and delete
				$model = $this->requestFactory->create();
				$model->load($id);
				$model->delete();
				// display success message
				$this->messageManager->addSuccessMessage(__('You deleted the Request.'));
				// go to grid
				return $resultRedirect->setPath('*/*/');
			} catch (\Exception $e) {
				// display error message
				$this->messageManager->addErrorMessage($e->getMessage());
				// go back to edit form
				return $resultRedirect->setPath('*/*/edit', ['request_id' => $id]);
			}
		}
		// display error message
		$this->messageManager->addErrorMessage(__('We can\'t find a Request to delete.'));
		// go to grid
		return $resultRedirect->setPath('*/*/');
	}
}
