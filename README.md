Products & CMS Pages Scheduler Magento 2

Usage:
- This Magento 2 extension is used to schedule products/CMS pages to be activated in a specific date interval. It can also be used to release a product or a page from a particular date 

Extension setup:
	Step 1: ​ Copy the code to the following path
		<M2 Root>/app/code/hatslogic/schedulemanager/

	Step 2: To complete the installation, run below commands
		php bin/magento module:enable hatslogic_schedulemanager 
		php bin/magento setup:upgradephp bin/magento 
		setup:static-content:deploy 


	Two new fields will show in add or edit pages of Products and CMS pages.
	
