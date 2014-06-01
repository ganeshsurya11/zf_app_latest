<?php

class Application_Model_User {
	
    protected $_id;
    protected $_username;
    protected $_password;
    protected $_gender;
    protected $_contact;
    protected $_email;
    protected $_country;
    protected $_role;
    
    public function __construct($data){
        $this->setOptions($data);
        //echo $this->getGender();
    }
    
    public function setOptions($data){
        $methods = get_class_methods($this);
        foreach($data as $k => $v){
            $method =  "set".ucwords($k);
            
           if(in_array($method, $methods)){
               $this->$method($v);
           }
        }
        
        return $this;
    }
    
    public function setId($id){
        $this->_id = $id;
    }
    
    public function getId(){
        return $this->_id;
    }
    
    public function setUsername($username){
        $this->_username = $username;
    }
    
    public function getUsername(){
        return $this->_username;
    }
    
    public function setPassword($password){
        $this->_password = $password;
    } 
    
    public function getPassword(){
        return $this->_password;
    }
    
    public function setGender($gender){
        $this->_gender = $gender;
    }
    
    public function getGender(){
       return $this->_gender; 
    }
    
    public function setContact($contact){
        $this->_contact = $contact;
    }
    
    public function getContact(){
        return $this->_contact;
    }
    
    public function setEmail($email){
        $this->_email = $email;
    }
    
    public function getEmail(){
        return $this->_email;
    }
    
    public function setCity($city){
        $this->_city = $city;
    }
    
    public function getCity(){
        return $this->_city;
    }
    
    public function setCountry($country){
        $this->_country = $country;
    }
    
    public function getCountry(){
        return $this->_country;
    }
    
    public function setRole($role){
        $this->_role = $role;
    }
    
    public function getRole(){
       return $this->_role;
    }

    public function toArray() {
        $vars = get_object_vars ( $this );
        $array = array ();
        foreach ( $vars as $key => $value ) {
            $array [ltrim ( $key, '_' )] = $value;
        }
        return $array;
    }
}

