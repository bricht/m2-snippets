<?php
/**
 * Added plugin to include the if conditional.
 */
declare(strict_types=1);

namespace Als\PlugsIn\Plugin\Observer;

use Magento\CatalogInventory\Model\Quote\Item\QuantityValidator;
use Magento\CatalogInventory\Observer\QuantityValidatorObserver;
use Magento\Framework\Event\Observer;

/**
 * Class QuantityValidatorObserverPlugin
 * @package Briteskies\ProductQtyValidation\Plugin\Observer
 */
class QuantityValidatorObserverPlugin
{
    /**
     * @var QuantityValidator
     */
    private $quantityValidator;

    /**
     * @param QuantityValidator $quantityValidator
     */
    public function __construct(
        QuantityValidator $quantityValidator
    ) {
        $this->quantityValidator = $quantityValidator;
    }

    /**
     * Completely overwrites the method execution.
     * @param QuantityValidatorObserver $subject
     * @param callable $proceed
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function aroundExecute(
        QuantityValidatorObserver $subject,
        callable $proceed,
        Observer $observer
    ) {
        if ($observer->getEvent()->getData('qty_changed') === true) {
            $this->quantityValidator->validate($observer);
        }
        return;
    }
}
