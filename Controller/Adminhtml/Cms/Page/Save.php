<?php

namespace Hatslogic\Schedulemanager\Controller\Adminhtml\Cms\Page;

use Magento\Cms\Model\Page;

class Save extends \Magento\Cms\Controller\Adminhtml\Page\Save
{
    const ADMIN_RESOURCE = 'Magento_Cms::save';

    protected $dataProcessor;
    protected $dataPersistor;

    /*
     * Save the Page publish attributes and redirect back to the page edit/add page with Success/Error message. 
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!isset($data)) {
            return $resultRedirect->setPath('*/*/');
        }
        
        $data   = $this->dataProcessor->filter($data);
        $data   = $this->setPageData($data);
        $model  = $this->_objectManager->create('Magento\Cms\Model\Page');
        $pageId = $this->getRequest()->getParam('page_id');
        
        if ($pageId) {
            $model->load($pageId);
        }
        $model->setData($data, $model);

        $this->_eventManager->dispatch(
            'cms_page_prepare_save',
            ['page' => $model, 'request' => $this->getRequest()]
        );

        if (!$this->dataProcessor->validate($data)) {
            return $resultRedirect->setPath('*/*/');
        }

        $isDataSaved = $this->savePageData($this->messageManager, $this->dataPersistor, $model);
        
        if (!$isDataSaved) {
            return $resultRedirect->setPath('*/*/edit', ['page_id' => $pageId]);
        }

        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['page_id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function setPageData($data)
    {
        if (isset($data['is_active']) && $data['is_active'] === 'true') {
            $data['is_active'] = Page::STATUS_ENABLED;
        }
        if (empty($data['page_id'])) {
            $data['page_id'] = null;
        }
        $data['published_from'] = $this->setPublishedData($data['published_from']);
        $data['published_to']   = $this->setPublishedData($data['published_to']);
        return $data;
    }

    public function setPublishedData($publishedData='')
    {
        if (isset($publishedData) && $publishedData != '' && $publishedData!= null) {
            return date("Y-m-d", strtotime($publishedData));
        } else {
            return null;
        }
    }

    /**
    * savePageData() fucntion for save page data
    * @return boolean
    */
     public function savePageData($messageManager, $dataPersistor, $model)
     {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource      = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection    = $resource->getConnection();
        $cmsPage       = $resource->getTableName('cms_page');

        try {
            $model->save();
            $messageManager->addSuccess(__('You saved the page.'));
            $dataPersistor->clear($cmsPage);
            return true;
        } catch (LocalizedException $e) {
            $messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $messageManager->addException($e, __('Something went wrong while saving the page.'));
        }

        return false;

    }//end savePageData()


}//end class
