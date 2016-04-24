<?php

class CourseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->course=new Application_Model_DbTable_Course();
        $this->categories=new Application_Model_DbTable_Category();
        $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity()) {
            $this->redirect('/');      
        }
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $form=new Application_Form_addcourse();
       if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                $this->view->data ;
                $this->course->addCourse($data);
            }  
        }
        $this->redirect('Admin/category-courses/id/'.$data['cid']);
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

    public function deleteAction()
    {
       $id=$this->getRequest()->id;
       $cid=$this->getRequest()->cid;
       $this->course->deleteCourse($id);
       $this->redirect('Admin/category-courses/id/'.$cid);
    }


}

