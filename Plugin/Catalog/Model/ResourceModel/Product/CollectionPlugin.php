<?php

namespace Hatslogic\Schedulemanager\Plugin\Catalog\Model\ResourceModel\Product;

class CollectionPlugin
{
    /**
     * @param Collection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     */
    public function beforeLoad(\Magento\Catalog\Model\ResourceModel\Product\Collection $subject, $printQuery = false, $logQuery = false)
    {    
        $subject->addAttributeToFilter(
            array(
                array('attribute' => 'product_scheduled_from','null' => true),
                array('attribute' => 'product_scheduled_from','lteq' => ltrim(date('m/d/Y'), 0)),
            )
        ); 
        $subject->addAttributeToFilter(
            array(
                array('attribute' => 'product_scheduled_to','null' => true),
                array('attribute' => 'product_scheduled_to','gteq' => ltrim(date('m/d/Y'), 0)),
            )
        );  
        return [$printQuery, $logQuery];
    }
}