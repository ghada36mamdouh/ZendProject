<?php

class MatrialController extends Zend_Controller_Action
{

    private $model = null;
    private $commentModel = null;
    private $courseModel = null;
    private $userModel = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new  Application_Model_DbTable_Material () ;
        $this->commentModel = new Application_Model_DbTable_Comment() ;
        $this->courseModel = new Application_Model_DbTable_Course() ;
        $this->userModel = new Application_Model_DbTable_User() ;
    }

    public function indexAction()
    {
    	$cid = $this->getRequest()->getParam('cid');
    	$courseMaterials = $this->model->listCourseMaterials($cid) ;
    	for($i=0 ; $i<count($courseMaterials); $i++){
    			$mid = $courseMaterials[$i]['id'] ;
    			$materialComments[$mid] = $this->commentModel->listMaterialComments($mid)  ;
              //  $materialUsers[$mid] = 
    	}
    	$this->view->course = $this->courseModel->getCourseById($cid) ;
        $this->view->courseMatrial =  $courseMaterials;
        $this->view->materialComments =  $materialComments;
       // $this->view->users =  $materialUsers;
        $this->view->type = $this->getRequest()->getParam('type');

        // $commentform = new Application_Form_AddComment();
        // $this->view->commentform = $commentform ; 

    }

    public function addAction()
    {
        $form = new Application_Form_AddMatrial();
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                $type =  $data['path'] ;
                $type = substr($type,strrpos( $type,'.')+1); 
                $data['type'] =$type ;            
                //var_dump($data);
                $this->model->addMaterial($data);               
                $this->redirect('/Matrial?cid='.$data['course_id'].'&type='.$type);
            }else{
                $cid = $this->getRequest()->getParam('cid');
                $cname = $this->getRequest()->getParam('cname');
                $this->redirect($baseUrl.'/Matrial/add?cid='.$cid.'&cname='.$cname);                
            }
        
        }else{
            $cid = $this->getRequest()->getParam('cid');
            //$form->setValue($value) ;
            $form->setDefault('course_id', $cid)  ;
            $this->view->cname = $this->getRequest()->getParam('cname');
            $this->view->form = $form ;
            }

    }
    public function deleteAction()
    {                             
        $mid = $this->getRequest()->getParam('mid');     
        $cid = $this->getRequest()->getParam('cid');     
        $type = $this->getRequest()->getParam('type');
        $delMaterial = $this->model->getMaterialById($mid); 
        $filename = $delMaterial[0]['path'] ;

        $old = getcwd(); 
        chdir($old.'/uploadedMatrials');
        chmod($filename,0777);
        unlink($filename);
            $this->commentModel->deleteMaterialComments($mid) ;    
            $this->model->deleteMaterial($mid); 
            chdir($old);
    
        $this->redirect('/Matrial?cid='.$cid.'&type='.$type);            
    }
}


