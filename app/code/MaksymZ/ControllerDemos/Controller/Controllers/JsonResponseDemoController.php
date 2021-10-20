<?php
declare(strict_types=1);

namespace MaksymZ\ControllerDemos\Controller\Controllers;

class JsonResponseDemoController implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;
    private \Magento\Framework\App\RequestInterface $request;

    /**
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\App\RequestInterface          $request
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute(): \Magento\Framework\Controller\Result\Json
    {
        $result = $this->jsonFactory->create();

        $vendorName = $this->request->getParam('vendorName', 'default');
        $moduleName = $this->request->getParam('moduleName', 'default');

        return $result->setData([
            'vendorName' => $vendorName,
            'moduleName' => $moduleName
        ]);
    }
}
