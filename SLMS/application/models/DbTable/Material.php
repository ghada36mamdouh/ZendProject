<?php

class Application_Model_DbTable_Material extends Zend_Db_Table_Abstract
{
    protected $_name = 'materials';

    function addMaterial($data){
		$row = $this->createRow();
		$row->type = $data['type'];
		$row->description = $data['description'];
		$row->path = $data['path'];
		/*$row->numdownloads = $data['numdownloads'];
		$row->enabledownload = $data['enabledownload'];
		$row->isshow = $data['isshow'];*/
		$row->course_id = $data['course_id'];
		return $row->save();
	}

	function listMaterials(){
		return $this->fetchAll()->toArray();
	}

	function listCourseMaterials($cid){
		$sql = $this->select()->setIntegrityCheck(false)->where('course_id='.$cid);
		return $this->fetchAll($sql)->toArray();
	}

	function getMaterialById($id){
		return $this->find($id)->toArray();
	}

	function editMaterial($id, $data){
		//$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$where = 'id ='.$id ;
		return $this->update($data, $where);
	}

	function deleteMaterial($id){
		return $this->delete('id='.$id);
	}
	function listCourseMaterialsByTypeAndNotBlock($cid,$t){
		$select = $this->select()->where('course_id='.$cid)->where(' isshow=1');
		return $this->fetchAll($select)->toArray();
	}

	function incrementDown($mid,$data){
		$where = $this->getAdapter()->quoteInto('id = ?', $mid);
		$data['numdownloads']=$data['numdownloads']+1;
		$this->update($data, $where);
	}
}

