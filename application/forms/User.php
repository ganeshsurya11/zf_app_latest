<?php

class Application_Form_User extends Zend_Form {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function init(){
		$this->setAttrib("autocomplete", "off");		
		$this->setAction('add-user');
                
                $this->addElement('text', 'id');
                
		$this->addElement('text', 'username', array('label' => 'Username'));
		$this->addElement('password', 'password', array('label' => 'Password'));
		
		$gender=array('male'=>'Male','female'=>'Female');
		$this->addElement('radio', 'gender', array('label' => 'Gender', 'multiOptions' => $gender));


		$this->addElement('text', 'contact', array('label' => 'Contact no'));

		$this->addElement('text', 'email', array('label' => 'Email'));

		$city=array('pune'=>'Pune','mumbai'=>'Mumbai');
		$this->addElement('multiCheckbox', 'city', array('label' => 'City', 'multiOptions' => $city));

		$country=array(''=> 'select', 'india'=>'India','russia'=>'Russia');
		$this->addElement('select', 'country', array('label' => 'Country', 'multiOptions'=>$country));
		

		$role=array(''=> 'select', 'user'=>'User','admin'=>'Admin');
		$this->addElement('select', 'role', array('label' => 'Role', 'multiOptions' => $role));

		$this->addElement('submit', 'submit');


//		$this->addEelement('password', 'password');

	}

	

}
