<?php

class Application_Model_UserMapper{

    protected $_table;
    
    public function __construct(){
        $this->_table = new Application_Model_DbTable_User;
    }
    
    public function save($data){
        $data = $data->toArray();
        if($data['id'] == ""){
            $this->_table->insert($data);
        }else{
            $this->_table->update($data, array('id =?' => $data['id']));
        }
        
    }
    
    public function fetchAllUsers(){
        $row = $this->_table->fetchAllUsers();
        return $row;
    }
    
    public function fetchUserById($id){ 
        $row = $this->_table->fetchUserById($id);
        $rowResult = $this->_table->fetchRow($row);
        return $rowResult->toArray();
    }
    
    public function deleteUser($id){
       $this->_table->delete(array('id=?' => $id)); 
    }
    
    public function fetchUserCompany(){
        return $this->_table->fetchUserCompany();
    }
    
}
