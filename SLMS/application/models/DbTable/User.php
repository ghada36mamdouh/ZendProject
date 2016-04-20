<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    function getUserByEmail($email){
/*
    	return $this->find($email)->toArray();*/
    	return $this->fetchRow($this->select()->where('email = ?', $email));
    }


}

