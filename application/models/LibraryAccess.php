<?php

class Application_Model_LibraryAccess extends Zend_Acl {
	public function __construct(){		
	
$this->add(new Zend_Acl_Resource('index'));
//$this->add(new Zend_Acl_Resource('index'), 'index');
	
		$this->add(new Zend_Acl_Resource('book'));
		$this->add(new Zend_Acl_Resource('edit'), 'book');
		$this->add(new Zend_Acl_Resource('add'), 'book');

		$this->add(new Zend_Acl_Resource('books'));
		$this->add(new Zend_Acl_Resource('list'), 'books');


		$this->add(new Zend_Acl_Resource('users'));
		$this->add(new Zend_Acl_Resource('add-user'), 'users');
		$this->add(new Zend_Acl_Resource('delete_user'), 'users');

		$this->add(new Zend_Acl_Resource('error'));
		//$this->add(new Zend_Acl_Resource('error'), 'error');


		$this->addRole(new Zend_Acl_Role('user'));
		$this->addRole(new Zend_Acl_Role('admin'), 'user');


		$this->allow('user', 'index', 'index');
		$this->allow('user', 'books', 'list');
		$this->allow('admin', 'book', 'add');
		$this->allow('admin', 'book', 'edit');

		$this->allow('admin', 'users', 'add-user');
		$this->allow('admin', 'users', 'delete-user');
		$this->allow('admin', 'users', 'edit-user');		

		$this->allow('user', 'error', 'error');
		
	}
}
