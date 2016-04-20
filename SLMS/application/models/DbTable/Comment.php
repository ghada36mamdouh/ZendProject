<?php

class Application_Model_DbTable_Comment extends Zend_Db_Table_Abstract
{

    protected $_name = 'comment';

    function addComment($data){
		$row = $this->createRow();
		$row->body = $data['body'];
		$row->uid = $data['uid'];
		$row->mid = $data['mid'];
		return $row->save();
	}

	function listComments(){
		return $this->fetchAll()->toArray();
	}
	function listMaterialComments($mid){
		$sql = $this->select()->setIntegrityCheck(false)->where('mid='.$mid);
		return $this->fetchAll($sql)->toArray();
	}
	function listUserComments($uid){
		$sql = $this->select()->setIntegrityCheck(false)->where('uid='.$uid);
		return $this->fetchAll($sql)->toArray();
	}

	function getCommentById($id){
		return $this->find($id)->toArray();
	}

	function editComment($id, $data){
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->update($data, $where);
	}

	function deleteComments($id){
		return $this->delete('id='.$id);
	}

}