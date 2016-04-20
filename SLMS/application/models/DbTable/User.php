<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    function getUserByEmail($email){
/*
    	return $this->find($email)->toArray();*/
    	return $this->fetchRow($this->select()->where('email = ?', $email));
    }

    function checkUnique($email)
    {
        $select = $this->_db->select();
        $select->from($this->_name,array('email'));
        $select->where('email=?',$email);
        $result = $this->getAdapter()->fetchOne($select);
        if($result){
            return true;
        }
        return false;
    }


}

