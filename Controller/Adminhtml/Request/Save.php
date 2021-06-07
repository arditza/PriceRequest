<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Azra\PriceRequest\Controller\Adminhtml\Request;

use Azra\PriceRequest\Model\RequestFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action {

	/**
	 * @var [type]
	 */
	protected $dataPersistor;

	/**
	 * @param Context                $context
	 * @param RequestFactory         $requestFactory
	 * @param DataPersistorInterface $dataPersistor
	 */
	public function __construct(
		Context $context,
		RequestFactory $requestFactory,
		DataPersistorInterface $dataPersistor
	) {
		$this->dataPersistor = $dataPersistor;
		$this->requestFactory = $requestFactory;
		parent::__construct($context);
	}

	/**
	 * Save action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute() {
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();
		$data = $this->getRequest()->getPostValue();
		if ($data) {
			$id = $this->getRequest()->getParam('request_id');

			$model = $this->requestFactory->create()->load($id);
			if (!$model->getId() && $id) {
				$this->messageManager->addErrorMessage(__('This Request no longer exists.'));
				return $resultRedirect->setPath('*/*/');
			}

			$model->setData($data);

			try {
				$model->save();
				$this->messageManager->addSuccessMessage(__('You saved the Request.'));
				$this->dataPersistor->clear('azra_pricerequest_request');

				if ($this->getRequest()->getParam('back')) {
					return $resultRedirect->setPath('*/*/edit', ['request_id' => $model->getId()]);
				}
				return $resultRedirect->setPath('*/*/');
			} catch (LocalizedException $e) {
				$this->messageManager->addErrorMessage($e->getMessage());
			} catch (\Exception $e) {
				$this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Request.'));
			}

			$this->dataPersistor->set('azra_pricerequest_request', $data);
			return $resultRedirect->setPath('*/*/edit', ['request_id' => $this->getRequest()->getParam('request_id')]);
		}
		return $resultRedirect->setPath('*/*/');
	}
}
