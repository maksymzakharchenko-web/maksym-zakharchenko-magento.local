<?php
declare(strict_types=1);

namespace MaksymZ\ControllerDemos\Controller\Controllers;

use Magento\Framework\Controller\Result\Forward;

class ForwardResponseDemoController implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory;

    /**
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    ) {
        $this->forwardFactory = $forwardFactory;
    }

    public function execute(): Forward
    {

        return $this->forwardFactory->create()
            ->forward('JsonResponseDemoController');
    }
}
