<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Azra\PriceRequest\Controller\Request;

use Azra\PriceRequest\Model\RequestFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 *
 */
class Post extends Action {

	/**
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * @var StoreManagerInterface
	 */
	protected $storeManager;

	/**
	 * @var RequestFactory
	 */
	protected $requestFactory;

	/**
	 * @var ProductRepositoryInterface
	 */
	protected $productRepository;

	/**
	 * @var JsonFactory
	 */
	protected $resultJsonFactory;

	/**
	 * @var ForwardFactory
	 */
	protected $resultForwardFactory;

	/**
	 * @param Context                    $context
	 * @param LoggerInterface            $logger
	 * @param JsonFactory                $resultJsonFactory
	 * @param RequestFactory             $requestFactory
	 * @param ForwardFactory             $resultForwardFactory
	 * @param StoreManagerInterface      $storeManager
	 * @param ProductRepositoryInterface $productRepository
	 */
	public function __construct(
		Context $context,
		LoggerInterface $logger,
		JsonFactory $resultJsonFactory,
		RequestFactory $requestFactory,
		ForwardFactory $resultForwardFactory,
		StoreManagerInterface $storeManager,
		ProductRepositoryInterface $productRepository
	) {
		$this->logger = $logger;
		$this->storeManager = $storeManager;
		$this->requestFactory = $requestFactory;
		$this->productRepository = $productRepository;
		$this->resultJsonFactory = $resultJsonFactory;
		$this->resultForwardFactory = $resultForwardFactory;

		parent::__construct($context);
	}

	/**
	 * Execute view action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute() {
		if (!$this->getRequest()->isAjax()) {
			return $this->resultForwardFactory->create()->forward('noroute');
		}
		try {
			$data = $this->validatedParams();
			$product = $this->productRepository->get($data["product_sku"]);
			$this->createPriceRequest($data);
			$response = [
				"success" => true,
				"message" => __("Your price request was create successfully. We will contact you with the information soon"),
			];
		} catch (LocalizedException $e) {
			$response = [
				"error" => true,
				"message" => $e->getMessage(),
			];
		} catch (\Exception | NoSuchEntityException $e) {
			$this->logger->critical($e);
			$response = [
				"error" => true,
				"message" => __("Something went wrong please try again later."),
			];
		}
		return $this->resultJsonFactory->create()->setData($response);
	}

	/**
	 * creates price request
	 *
	 * @param  array $data
	 * @return array
	 */
	protected function createPriceRequest($data) {
		$priceRequest = $this->requestFactory->create();
		$store = $this->storeManager->getStore();
		$priceRequest->setData($data);
		$priceRequest->setData("store_id", $store->getId());
		$priceRequest->save();
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	private function validatedParams() {
		$request = $this->getRequest();
		if (!$request->getParam('user_full_name') || trim($request->getParam('user_full_name')) === '') {
			throw new LocalizedException(__('Enter the Name and try again.'));
		}
		if (!$request->getParam('product_sku') || trim($request->getParam('product_sku')) === '') {
			throw new LocalizedException(__('Something went wrong please try again later.'));
		}
		if (false === \strpos($request->getParam('email'), '@')) {
			throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
		}
		if (is_null($request->getParam('hideit')) || trim($request->getParam('hideit')) !== '') {
			throw new \Exception();
		}

		return $request->getParams();
	}
}
