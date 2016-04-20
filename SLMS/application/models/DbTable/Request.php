<?php

class Application_Model_DbTable_Request extends Zend_Db_Table_Abstract
{

    protected $_name = 'request';

    function addRequest($data){
		$row = $this->createRow();
		$row->body = $data['body'];
		$row->uid = $data['uid'];
		return $row->save();
	}

	function listRequests(){
		return $this->fetchAll()->toArray();
	}
	function listUserRequest($uid){
		$sql = $this->select()->setIntegrityCheck(false)->where('uid='.$uid);
		return $this->fetchAll($sql)->toArray();
	}
	function getRequestById($id){
		return $this->find($id)->toArray();
	}

	function editRequest($id, $data){
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->update($data, $where);
	}

	function deleteRequest($id){
		return $this->delete('id='.$id);
	}
}
