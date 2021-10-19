<?php
declare(strict_types=1);

namespace MaksymZ\ControllerDemos\Controller\Controllers;

use Magento\Framework\Controller\Result\Redirect;

class RedirectResponseDemoController implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory;

    /**
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    ) {
        $this->redirectFactory = $redirectFactory;
    }

    public function execute(): Redirect
    {
        $result = $this->redirectFactory->create();

        return $result->setUrl('https://github.com/maksymzakharchenko-web/maksym-zakharchenko-magento');
    }
}
