<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';

    function addUser($data){
		$row = $this->createRow();
		$row->name = $data['name'];
		$row->email = $data['email'];
		$row->password = md5($data['password']);
		$row->gender = $data['gender'];
		$row->country = $data['country'];
		return $row->save();
	}
	function listUsers(){
		return $this->fetchAll()->toArray();
	}
	function getUserById($id){
		return $this->find($id)->toArray();
	}

	function editUser($id, $data){
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->update($data, $where);
	}
	function deleteUser($id){
		return $this->delete('id='.$id);
	}
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

