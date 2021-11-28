<?php

declare(strict_types=1);

namespace MaksymZ\RegularCustomer\Controller\Index;

use MaksymZ\RegularCustomer\Model\RegularCustomer;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;

class Request implements
    \Magento\Framework\App\Action\HttpPostActionInterface,
    \Magento\Framework\App\CsrfAwareActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface $messageManager
     */
    private \Magento\Framework\Message\ManagerInterface $messageManager;

    /**
     * @var \MaksymZ\RegularCustomer\Model\RegularCustomerFactory $regularCustomerRequestFactory
     */
    private \MaksymZ\RegularCustomer\Model\RegularCustomerFactory $regularCustomerRequestFactory;

    /**
     * @var \MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer $regularCustomerRequestResource
     */
    private \MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer $regularCustomerRequestResource;

    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private \Magento\Framework\App\RequestInterface $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private \Psr\Log\LoggerInterface $logger;

    /**
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \MaksymZ\RegularCustomer\Model\RegularCustomerFactory $regularCustomerFactory
     * @param \MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer $regularCustomerRequestResource
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory         $redirectFactory,
        \Magento\Framework\Message\ManagerInterface                  $messageManager,
        \MaksymZ\RegularCustomer\Model\RegularCustomerFactory        $regularCustomerFactory,
        \MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer $regularCustomerRequestResource,
        \Magento\Framework\App\RequestInterface                      $request,
        \Magento\Store\Model\StoreManagerInterface                   $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator               $formKeyValidator,
        \Psr\Log\LoggerInterface                                     $logger
    )
    {
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
        $this->regularCustomerRequestFactory = $regularCustomerFactory;
        $this->regularCustomerRequestResource = $regularCustomerRequestResource;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->logger = $logger;
    }

    /**
     * Controller action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $regularCustomerRequest = $this->regularCustomerRequestFactory->create();

        try {
            $regularCustomerRequest->setProductId((int)$this->request->getParam('product_id'))
                ->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setStoreId($this->storeManager->getStore()->getId());

            $this->regularCustomerRequestResource->save($regularCustomerRequest);
            $this->messageManager->addSuccessMessage(
                __('You request for product %1 accepted for review!', $this->request->getParam('productName'))
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->messageManager->addErrorMessage(
                __('Your request can\'t be sent. Please, contact us if you see this message.')
            );
        }

        $redirect = $this->redirectFactory->create();
        $redirect->setRefererUrl();

        return $redirect;
    }

    /**
     * Create exception in case CSRF validation failed. Return null if default exception will suffice.
     *
     * @param RequestInterface $request
     * @return InvalidRequestException|null
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * Perform custom request validation. Return null if default validation is needed.
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function validateForCsrf(RequestInterface $request): bool
    {
        return $this->formKeyValidator->validate($request);
    }
}
