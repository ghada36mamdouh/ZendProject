<?php

class MatrialController extends Zend_Controller_Action
{
	private $model = null  ;
	private $commentModel = null  ;
	private $courseModel = null  ;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new  Application_Model_DbTable_Material () ;
        $this->commentModel = new Application_Model_DbTable_Comment() ;
        $this->courseModel = new Application_Model_DbTable_Course() ;
    }

    public function indexAction()  
    {
    	$cid = $this->getRequest()->getParam('cid');
    	//$this->view->courseMatrial = $mid ;
    	$courseMaterials = $this->model->listCourseMaterials($cid) ;
    	for($i=0 ; $i<count($courseMaterials); $i++){
    			$mid = $courseMaterials[$i]['id'] ;
    			$materialComments[$mid] = $this->commentModel->listMaterialComments($mid)  ;
    	}
    	$this->view->course = $this->courseModel->getCourseById($cid) ;
        $this->view->courseMatrial =  $courseMaterials;
        $this->view->materialComments =  $materialComments;

    }


}

