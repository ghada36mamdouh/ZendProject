<?php

class MatrialController extends Zend_Controller_Action
{

    private $model = null;
    private $commentModel = null;
    private $courseModel = null;
    private $userModel = null;

    public function init()
    {
        $this->model = new  Application_Model_DbTable_Material () ;
        $this->commentModel = new Application_Model_DbTable_Comment() ;
        $this->courseModel = new Application_Model_DbTable_Course() ;
        $this->userModel = new Application_Model_DbTable_User() ;
        $this->matrialModel = new Application_Model_DbTable_Material() ;
        $this->categories=new Application_Model_DbTable_Category();
        $this->addmaterialForm=new Application_Form_AddMatrial();
    }

    public function indexAction()
    {
        $cid = $this->getRequest()->getParam('cid');
        $courseMaterials = $this->model->listCourseMaterials($cid) ;
        for($i=0 ; $i<count($courseMaterials); $i++){
                $mid = $courseMaterials[$i]['id'] ;
                $MaterialcommentsBlocks[$mid] = $this->commentModel->getMaterialcommentsBlocks($mid) ;
        }
        $this->view->course = $this->courseModel->getCourseById($cid) ;
        $this->view->courseMatrial =  $courseMaterials;        
        $this->view->MaterialcommentsBlocks = $MaterialcommentsBlocks ;
        $this->view->type = $this->getRequest()->getParam('type');
        $this->view->editComId = $this->getRequest()->getParam('editComId');
        $this->view->addform = new Application_Form_AddMatrial();
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
//------------------------------------------------------------
     public function editAction()
    {                             
        $mid = $this->getRequest()->getParam('mid');     
        $cid = $this->getRequest()->getParam('cid');     
        $type = $this->getRequest()->getParam('type');
        $editedMaterial = $this->model->getMaterialById($mid);

        $oldfile = $editedMaterial[0]['path'] ;
        $materialCourse_id = $editedMaterial[0]['course_id'] ;

        $form = new Application_Form_AddMatrial();
        if($this->getRequest()->isPost()){
            //$addform->setDefault('hiddenpath',$courseMatrial[$i]['path']);
            // $form->file->setRequired(false);
            var_dump($form->getValue('path')) ;
            var_dump($form->getValue('hiddenpath')) ;

            if($form->getValue('path') == null){
                $form->setDefault('path', $form->getValue('hiddenpath'));
            }
            if($form->isValid($_POST)){
                $data = $form->getValues();
                $type =  $data['path'] ;
                $type = substr($type,strrpos($type,'.')+1); 
                $data['type'] =$type ;            
                $data['course_id'] =$materialCourse_id ;            
                $this->model->editMaterial($mid,$data); 
                $old = getcwd(); 
                chdir($old.'/uploadedMatrials');
                chmod($oldfile,0777);
                unlink($oldfile);
                chdir($old);                     
            }
        }
        $this->redirect('/Matrial?cid='.$cid.'&type='.$type);            
    }
//--------------------------------------------------------------
    public function visibleAction()
    {                             
        $v = $this->getRequest()->getParam('v');     
        $mid = $this->getRequest()->getParam('mid');     
        $cid = $this->getRequest()->getParam('cid');     
        $type = $this->getRequest()->getParam('type');
        $data = array('isshow' => $v) ;
        $this->model->editMaterial($mid,$data) ;
        $this->redirect('/Matrial?cid='.$cid.'&type='.$type);            
    }
    public function lockAction()
    {                             
        $l = $this->getRequest()->getParam('l');     
        $mid = $this->getRequest()->getParam('mid');     
        $cid = $this->getRequest()->getParam('cid');     
        $type = $this->getRequest()->getParam('type');
        $data = array('enabledownload' => $l) ;
        $this->model->editMaterial($mid,$data) ;
        $this->redirect('/Matrial?cid='.$cid.'&type='.$type);            
    }

    function listAction()
    {
        // action body


        $LoginedUser=Zend_Auth::getInstance();
        if($LoginedUser->hasIdentity())
        {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $this->view->user=$authNamespace->user;
            $this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();

            $courseID=$this->getRequest()->cid;
            $type=$this->getRequest()->type;

            $matrials=$this->matrialModel->listCourseMaterialsByTypeAndNotBlock($courseID,$type);
            $this->view->materials=$matrials;

            $this->view->addmaterialform = $this->addmaterialForm;

        }
        else
        {
            $logInform = new Application_Form_Login();
            $this->view->loginform = $logInform;

            $registform = new Application_Form_Regist();
            $this->view->registform = $registform;
        }
    }

    function indetailsAction()
    {

        $LoginedUser=Zend_Auth::getInstance();
        if($LoginedUser->hasIdentity())
        {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $this->view->user=$authNamespace->user;
            $this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();

            $mid=$this->getRequest()->mid;

            $matrials=$this->matrialModel->getMaterialById($mid);
            $this->view->materials=$matrials[0];

            $comments=$this->commentModel->listMaterialComments($mid);
            $this->view->comments=$comments;



        }
        else
        {
            $logInform = new Application_Form_Login();
            $this->view->loginform = $logInform;

            $registform = new Application_Form_Regist();
            $this->view->registform = $registform;
        }
    }

    function viewAction()
    {
        $LoginedUser=Zend_Auth::getInstance();
        if($LoginedUser->hasIdentity())
        {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $this->view->user=$authNamespace->user;
            $this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();

            $mid=$this->getRequest()->mid;

            $matrials=$this->matrialModel->getMaterialById($mid);
            $this->view->materials=$matrials[0];
            /*$comments=$this->commentModel->listMaterialComments($mid);
            $this->view->comments=$comments;
*/
        }
        else
        {
            $logInform = new Application_Form_Login();
            $this->view->loginform = $logInform;

            $registform = new Application_Form_Regist();
            $this->view->registform = $registform;
        }

    }

    function downloadAction()
    {
        $LoginedUser=Zend_Auth::getInstance();
        if($LoginedUser->hasIdentity())
        {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $this->view->user=$authNamespace->user;
            $this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();

            $mid=$this->getRequest()->mid;

            $matrials=$this->matrialModel->getMaterialById($mid);

            $matrials=$this->matrialModel->incrementDown($mid,$matrials[0]);
            $this->view->materials=$matrials[0];
        }
        else
        {
            $logInform = new Application_Form_Login();
            $this->view->loginform = $logInform;

            $registform = new Application_Form_Regist();
            $this->view->registform = $registform;
        }
    }


}





