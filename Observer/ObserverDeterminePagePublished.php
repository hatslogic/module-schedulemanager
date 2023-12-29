<?php
namespace Hatslogic\Schedulemanager\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class ObserverDeterminePagePublished implements ObserverInterface
{
    protected $_responseFactory;
    protected $_url;
    public function __construct(
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Cms\Model\Page $page
    ) {
        $this->_responseFactory = $responseFactory;
        $this->_url = $url;
        $this->_page = $page;
    }

    public function execute(Observer $observer)
    {
        $publishedFrom = $this->_page->getPublishedFrom();
        $publishedTo = $this->_page->getPublishedTo();
        $isPublished = $this->isPagePublished($publishedFrom, $publishedTo);
        if (!$isPublished) {
            $event = $observer->getEvent();
            $customUrl = 'home';
            $this->_responseFactory->create()->setRedirect($customUrl)->sendResponse(); 
        }
    }

    /**
    * isPagePublished()
    * checking the page is published or not
    * @return boolean
    */
    public function isPagePublished($publishedFrom, $publishedTo)
    {
        if (($publishedFrom !== '' && $publishedFrom >= date('Y-m-d')) || ($publishedTo !== '' && $publishedTo <= date('Y-m-d'))) {
            return false;
        } else {
            return true;
        }

    }//end isPagePublished()


}//end class
