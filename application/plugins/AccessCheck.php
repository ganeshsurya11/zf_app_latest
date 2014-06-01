<?php

class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{

	private $_acl = null;
	private $_auth = null;
	
	public function __construct(Zend_Auth $auth, Zend_Acl $acl){
		$this->_acl = $acl;
		$this->_auth = $auth;
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$contName = $request->getControllerName();
		echo $actionName = $request->getActionName();
	
		$identity = $this->_auth->getStorage()->read();

//print_r($identity); 

		$role = $identity->role;

		if($this->_acl->isAllowed($role, $contName, $actionName)){
			echo "Allowed";
		}else{
			echo "not allowed";
		}

	}
	
	

}
