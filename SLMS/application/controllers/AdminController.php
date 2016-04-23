<?php

class AdminController extends Zend_Controller_Action
{

    private $userModel = null;
    private $categoryModel=null;
    private $courseModel=null;
    private $materialModel=null;
    private $commentModel=null;
    private $requestModel=null;

    public function init()
    {
       $this->userModel = new Application_Model_DbTable_User();
       $this->categoryModel=new Application_Model_DbTable_Category();
       $this->courseModel=new Application_Model_DbTable_Course();
       $this->materialModel=new Application_Model_DbTable_Material();
       $this->commentModel=new Application_Model_DbTable_Comment();
       $this->requestModel=new Application_Model_DbTable_Request();
       $this->view->categories=$this->categoryModel->listCategories();

       $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity()) {
            $this->redirect('/');      
        }
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        $this->view->user=$authNamespace->user;
        if($authNamespace->user['type']!='admin') {
            $this->redirect('/');      
        }
        $this->view->logged=True;
                   
    }

    public function indexAction()
    {

    }
    public function listUsersAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id)
            $this->view->id=$id;    
        $this->view->users = $this->userModel->listUsers();
    }
    public function listCategoriesAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id)
            $this->view->id=$id;  
        $this->view->categories = $this->categoryModel->listCategories();
    }
    public function listRequestsAction()
    {
        $courses=$this->courseModel->listCourses();
        $this->view->courses=$courses;
        $id = $this->getRequest()->getParam('id');
        $cid=0;
        if($id)
            $cid=$id-1;
        
        $this->view->requests = $this->requestModel->listRequestsandUsers($courses[$cid]['id']);

    }
    public function categoryCoursesAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($id)
            $this->view->courses = $this->courseModel->listCategoryCourses($id);
    }
    public function addUserAction()
    {
        $form=new Application_Form_Regist();
        $URL="../User/add";
        $form->setAction($URL);
        $form->removeElement('photo');
        $form->getElement('Register')->setLabel('Add');
        $form->removeElement('confirmPassword');
        $form->removeElement('signature');
        $this->view->form =$form; 
    }
    public function addCategoryAction()
    {
        $this->view->form=new Application_Form_addcategory;
    }

}



