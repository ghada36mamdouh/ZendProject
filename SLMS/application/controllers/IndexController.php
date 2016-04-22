<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
       
    }

    public function indexAction()
    {
        // action body
        $requestForm = new Application_Form_Request();
    	$LoginedUser=Zend_Auth::getInstance();
    	if($LoginedUser->hasIdentity())
    	{
    		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    		$this->view->user=$authNamespace->user;
    		$this->view->logged=True;
            $this->view->requestform=$requestForm;
            /*
            var_dump($requestForm);*/

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

