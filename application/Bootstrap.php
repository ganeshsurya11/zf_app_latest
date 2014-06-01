<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

		protected function _initAutoload(){ 
				$acl = new Application_Model_LibraryAccess;
				$auth = Zend_Auth::getInstance(); 	
				$fc=Zend_Controller_Front::getInstance();
				$fc->registerPlugin(new Application_Plugin_AccessCheck($auth, $acl));        
    }
 	
	 	
}

