<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'categories';

    function addCategory($data){
		$row = $this->createRow();
		$row->name = $data['name'];
		$row->description = $data['description'];
		return $row->save();
	}
	function listCategories(){
		return $this->fetchAll()->toArray();
	}
	function getCategoryById($id){
		return $this->find($id)->toArray();
	}

	function editCategory($id, $data){
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->update($data, $where);
	}
	function deleteCategory($id){
		return $this->delete('id='.$id);
	}

}

