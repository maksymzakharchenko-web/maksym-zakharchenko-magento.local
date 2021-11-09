<?php

declare(strict_types=1);

namespace MaksymZ\Cms\Controller\Index;

use Magento\Framework\View\Result\Page;

class HeadOfThePage implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(\Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    /**
     * Page result demo: https://maksym-zakharchenko-magento.local/maksymz-cms/index/headofthepage
     *
     * @return Page
     */
    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
