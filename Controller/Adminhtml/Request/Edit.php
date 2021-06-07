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
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Azra\PriceRequest\Controller\Adminhtml\Request {

	/**
	 * @var RequestFactory
	 */
	protected $requestFactory;

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @param Context        $context
	 * @param Registry       $coreRegistry
	 * @param RequestFactory $requestFactory
	 * @param PageFactory    $resultPageFactory
	 */
	public function __construct(
		Context $context,
		Registry $coreRegistry,
		RequestFactory $requestFactory,
		PageFactory $resultPageFactory
	) {
		$this->requestFactory = $requestFactory;
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context, $coreRegistry);
	}

	/**
	 * Edit action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute() {

		$id = $this->getRequest()->getParam('request_id');
		$model = $this->requestFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Request no longer exists.'));
				/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('*/*/');
			}
		}
		$this->_coreRegistry->register('azra_pricerequest_request', $model);

		// 3. Build edit form
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$this->initPage($resultPage)->addBreadcrumb(
			$id ? __('Edit Request') : __('New Request'),
			$id ? __('Edit Request') : __('New Request')
		);
		$resultPage->getConfig()->getTitle()->prepend(__('Requests'));
		$resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Request %1', $model->getId()) : __('New Request'));
		return $resultPage;
	}
}
