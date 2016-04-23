<?php

class Application_Model_DbTable_Course extends Zend_Db_Table_Abstract
{
    protected $_name = 'courses';

    function addCourse($data){
		$row = $this->createRow();
		$row->name = $data['name'];
		$row->description = $data['description'];
		$row->cid = $data['cid'];
		return $row->save();
	}

	function listCourses(){
		return $this->fetchAll()->toArray();
	}
	function listCategoryCourses($cid){
		/*$sql = $this->select()->setIntegrityCheck(false)->where('cid='.$cid);
		return $this->fetchAll($sql)->toArray();*/

		$select = $this->select()->from('courses')->join(array('c'=>'categories'),'courses.cid = c.id',array('cname'=>'name'))->where("courses.cid =".$cid)->setIntegrityCheck(FALSE); 
		$result = $this->fetchAll($select)->toArray();
		return $result;
	}
	function getCourseById($id){
		return $this->find($id)->toArray();
	}

	function editCourse($id, $data){
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->update($data, $where);
	}

	function deleteCourse($id){
		return $this->delete('id='.$id);
	}

}

