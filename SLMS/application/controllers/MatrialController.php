<?php

class MatrialController extends Zend_Controller_Action
{

    private $model = null;
    private $commentModel = null;
    private $courseModel = null;

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
    	$courseMaterials = $this->model->listCourseMaterials($cid) ;
    	for($i=0 ; $i<count($courseMaterials); $i++){
    			$mid = $courseMaterials[$i]['id'] ;
    			$materialComments[$mid] = $this->commentModel->listMaterialComments($mid)  ;
    	}
    	$this->view->course = $this->courseModel->getCourseById($cid) ;
        $this->view->courseMatrial =  $courseMaterials;
        $this->view->materialComments =  $materialComments;
        $this->view->type = $this->getRequest()->getParam('type');
        $commentform = new Application_Form_AddComment();
        $this->view->commentform = $commentform ; 

    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_AddMatrial();
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                var_dump($data);
                $this->model->addMaterial($data);               
                //$this->redirect('/');
            }
        }else{
            $cid = $this->getRequest()->getParam('cid');
            //$form->setValue($value) ;
            $form->setDefault('course_id', $cid)  ;
            $this->view->cname = $this->getRequest()->getParam('cname');
            $this->view->form = $form ;
        }

    }
}



