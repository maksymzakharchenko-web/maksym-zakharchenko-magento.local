<?php

declare(strict_types=1);

namespace MaksymZ\RegularCustomer\ViewModel\Customer;

use MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer\CollectionFactory
    as CustomerRequestCollectionFactory;
use MaksymZ\RegularCustomer\Model\ResourceModel\RegularCustomer\Collection as RegularCustomerRequestCollection;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\Product;
use Magento\Store\Model\Website;

class RequestList implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var CustomerRequestCollectionFactory $regularCustomerRequestCollectionFactory
     */
    private CustomerRequestCollectionFactory $regularCustomerRequestCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var RegularCustomerRequestCollection $loadedRegularCustomerRequestCollection
     */
    private RegularCustomerRequestCollection $loadedRegularCustomerRequestCollection;

    /**
     * @var ProductCollection $loadedProductCollection
     */
    private ProductCollection $loadedProductCollection;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility $productVisibility
     */
    private \Magento\Catalog\Model\Product\Visibility $productVisibility;

    /**
     * @param CustomerRequestCollectionFactory $customerRequestRequestCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Product\Visibility $productVisibility
     */
    public function __construct(
        CustomerRequestCollectionFactory $customerRequestRequestCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Product\Visibility $productVisibility
    ) {
        $this->regularCustomerRequestCollectionFactory = $customerRequestRequestCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productVisibility = $productVisibility;
    }

    /**
     * Get a list of regular customer issues
     *
     * @return RegularCustomerRequestCollection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRegularCustomerRequestCollection(): RegularCustomerRequestCollection
    {
        if (isset($this->loadedRegularCustomerRequestCollection)) {
            return $this->loadedRegularCustomerRequestCollection;
        }

        /** @var Website $website */
        $website = $this->storeManager->getWebsite();

        /** @var RegularCustomerRequestCollection $collection */
        $collection = $this->regularCustomerRequestCollectionFactory->create();
        // @TODO: get current customer's ID
        // $collection->addFieldToFilter('customer_id', 2);
        // @TODO: check if accounts are shared per website or not
        $collection->addFieldToFilter('store_id', ['in' => $website->getStoreIds()]);
        $this->loadedRegularCustomerRequestCollection = $collection;

        return $this->loadedRegularCustomerRequestCollection;
    }

    /**
     * Get product for regular customers request
     *
     * @param $productId
     * @return Product|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProduct($productId): ?Product
    {
        if (isset($this->loadedProductCollection)) {
            return $this->loadedProductCollection->getItemById($productId);
        }

        $regularCustomerRequestCollection = $this->getRegularCustomerRequestCollection();
        $productIds = array_unique(array_filter($regularCustomerRequestCollection->getColumnValues('product_id')));

        $productCollection = $this->productCollectionFactory->create();
        // Inactive products are filtered by default
        $productCollection->addAttributeToFilter('entity_id', ['in' => $productIds])
            ->addAttributeToSelect('name')
            ->addWebsiteFilter()
            ->setVisibility($this->productVisibility->getVisibleInSiteIds());
        $this->loadedProductCollection = $productCollection;

        return $this->loadedProductCollection->getItemById($productId);
    }
}
