<?php

class UsersController extends Zend_Controller_Action {
        
       public $form;
       public $mapper;
                
        public function init(){
            $this->mapper = new Application_Model_UserMapper;
        }

	public function indexAction(){
           $this->view->users = $this->mapper->fetchAllUsers();
           //echo "<pre>";
           //print_r($this->mapper->fetchUserCompany());
           
           $session = new Zend_Session_Namespace('product');
           $session->fname = "ganesh";
           //$session->count = 1;
           
           $action = "add";
           
           switch($action) {
            case "add":
                $session->count++;
            break;
            case "remove":
                $session->count--;
            break;
            case "empty":
                $session->count = 0;
             break;
           }
           echo $session->count;
           
	}

	 

	public function addUserAction(){
		$this->form = new Application_Form_User('add-user');
		$this->view->form = $this->form;
                //$postValues = $this->getRequest()->getPost()  
                if($this->getRequest()->isPost()){
                    
                    $postValues=$this->getRequest()->getPost();
                   
                    if($this->form->isValid($postValues)){
                        
                         $getValues = $this->form->getValues();
                        
                       // print_r($getValues);
                       if($getValues['city']){
                           $getValues['city'] = implode(",", $getValues['city']);
                       }
                        
                       $userModal = new Application_Model_User($getValues);
                       $this->mapper->save($userModal);
                         
                           $this->_redirect('/users/index');
                       
                       //echo "<pre>"
                       //print_r($userModal);
                    }
                    
                }
	}

	public function editUserAction(){
            $this->form = new Application_Form_User();
            $this->view->form = $this->form;
            $r = $this->mapper->fetchUserById($this->getParam('id'));
            if($r['city']){
               $r['city'] = explode(",", $r['city']); 
            }
            $this->form->populate($r);
             
            if($this->getRequest()->isPost()){
                $this->mapper->save($r);   
                $this->_redirect('/users/index');
            }
	}

	public function deleteUserAction(){
             $id = $this->getParam('id');
            if($id){
                $this->mapper->deleteUser($id);
                $this->_redirect('/users/index');
            }    
	}	

}
