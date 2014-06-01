<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	
				$authAdapter = $this->getAuthAdapter();
				$username = "admin";
				$password = md5("admin");
				$authAdapter->setIdentity($username);
				$authAdapter->setCredential($password);
//				$authAdapter->setCredentialTreatment($password);
				
				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($authAdapter);
				
				if($result->isValid($result)){
					//echo "valid";
					$user = $authAdapter->getResultRowObject();
					$store = $auth->getStorage();
					$s = $store->write($user);
	//echo $store->read()->username;				
//				print_r($store->read());
//echo "<pre>";
	//		print_r($_SESSION);
				
				}
    }

		public function getAuthAdapter(){
			$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
			$authAdapter->setTableName('user');
			$authAdapter->setIdentityColumn('username');
			$authAdapter->setCredentialColumn('password');
			//$authAdapter->setCredentialTreatment('md5');
		
			return $authAdapter;
		}


}

