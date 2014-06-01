<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract {

    protected $_name="user";
    
    public function init(){
         $select = $this->select()->from($this->_name);
            
        
    }
    
    public function fetchUserById($id){
        $row = $this->select()
                ->from($this->_name)
                ->where('id = ?', $id);
        
        return $row;
    }
    
    public function fetchAllUsers(){
         $select = $this->select()
                 ->from($this->_name, array('*'))
                 ->group('username');
                 //->order('id asc')
                 //->limit(20);
        // echo $select; exit;
        $result = $select->query();
        $row = $result->fetchAll();
        return $row;
    }
    
    public function fetchUserCompany(){
        $select = $this->select()
                ->from(array('u' => 'user'),
                        array('id', 'username','contact'))
                ->joinLeft(array('c' => 'company'), 'u.id = c.user_id')
                ->setIntegrityCheck(false);
        $result = $select->query();
       
        return $result->fetchAll();
    }

}
