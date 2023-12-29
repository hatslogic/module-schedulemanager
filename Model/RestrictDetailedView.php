<?php
namespace Hatslogic\Schedulemanager\Model;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
class RestrictDetailedView implements ObserverInterface
{
    protected $_storeManager;

    /**
     * RestrictWebsite constructor.
     */
    public function __construct(
    ) {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $productId = $observer->getEvent()->getRequest()->getParam('id');
        $product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($productId);
        $isScheduled = $this->isProductScheduled($product);
        if (!$isScheduled) {
            $observer->getEvent()->getRequest()->setParam('id', 0);
        }
    }

    public function isProductScheduled($product)
    {
        $ScheduledFrom = date('Y-m-d', strtotime($product->getProductScheduledFrom()));
        $ScheduledTo = date('Y-m-d', strtotime($product->getProductScheduledTo()));
        if (($product->getProductScheduledFrom()!= '' && $ScheduledFrom >= date('Y-m-d')) || ($product->getProductScheduledTo() != '' && $ScheduledTo <= date('Y-m-d'))) {
            return false;
        } else {
            return true;
        }
    }
}
