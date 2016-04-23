<?php

class CourseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->course=new Application_Model_DbTable_Course();
        $this->categories=new Application_Model_DbTable_Category();
    }

    public function indexAction()
    {
        // action body
    }
    
    function listAction()
    {
        // action body


	    $LoginedUser=Zend_Auth::getInstance();
    	if($LoginedUser->hasIdentity())
    	{
    		$courses=$this->course->listCategoryCourses($this->getRequest()->id);
    		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    		$this->view->user=$authNamespace->user;
    		$this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();
	    	$this->view->courses=$courses;
	    	$this->view->category=$this->categories->getCategory($this->getRequest()->id)[0];


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
        // action body


	    $LoginedUser=Zend_Auth::getInstance();
    	if($LoginedUser->hasIdentity())
    	{
    		$course=$this->course->getCourseById($this->getRequest()->id);
    		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    		$this->view->user=$authNamespace->user;
    		$this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();
	    	$this->view->course=$course[0];


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

