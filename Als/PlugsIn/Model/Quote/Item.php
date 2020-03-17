<?php
/**
 * Added to pass the qty_changed value to the event
 * in order to stop firing qty validation unnecessarily.
 */
declare(strict_types=1);

namespace Als\PlugsIn\Model\Quote;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Quote\Model\Quote\Item\Compare;
use Magento\Quote\Model\Quote\Item\OptionFactory;
use Magento\Sales\Model\Status\ListFactory;

class Item extends \Magento\Quote\Model\Quote\Item
{

    /**
     * Item constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param ListFactory $statusListFactory
     * @param FormatInterface $localeFormat
     * @param OptionFactory $itemOptionFactory
     * @param Compare $quoteItemCompare
     * @param StockRegistryInterface $stockRegistry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        ListFactory $statusListFactory,
        FormatInterface $localeFormat,
        OptionFactory $itemOptionFactory,
        Compare $quoteItemCompare,
        StockRegistryInterface $stockRegistry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $productRepository,
            $priceCurrency,
            $statusListFactory,
            $localeFormat,
            $itemOptionFactory,
            $quoteItemCompare,
            $stockRegistry,
            $resource,
            $resourceCollection,
            $data,
            $serializer
        );
    }

    /**
     * Declare quote item quantity
     * Pass the qty_changed value in the event
     *
     * @param float $qty
     * @return $this
     */
    public function setQty($qty)
    {
        $qty = $this->_prepareQty($qty);
        $oldQty = $this->_getData(parent::KEY_QTY);
        $this->setData(parent::KEY_QTY, $qty);

        $this->_eventManager->dispatch(
            'sales_quote_item_qty_set_after',
            [
                'item' => $this,
                'qty_changed' => (int)$qty !== (int)$oldQty
            ]
        );

        if ($this->getQuote() && $this->getQuote()->getIgnoreOldQty()) {
            return $this;
        }

        if ($this->getUseOldQty()) {
            $this->setData(parent::KEY_QTY, $oldQty);
        }

        return $this;
    }
}
