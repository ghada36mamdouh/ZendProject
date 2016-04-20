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
       
    }

    public function indexAction()
    {
      $authorization =Zend_Auth::getInstance();
      if(!$authorization->hasIdentity()) {
          $this->redirect('/');      
      }
      $authNamespace = new Zend_Session_Namespace('Zend_Auth');
      $this->view->user=$authNamespace->user;
    }
    public function listUsersAction()
    {
        $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity()) {
            $this->redirect('/');      
        }
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        $this->view->user=$authNamespace->user;
        $this->view->users = $this->userModel->listUsers();
    }


}



