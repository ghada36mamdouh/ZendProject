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

    	$LoginedUser=Zend_Auth::getInstance();
    	if($LoginedUser->hasIdentity())
    	{
    		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    		$this->view->user=$authNamespace->user;
    		$this->view->logged=True;
    	}
    	else
    	{
	        $form = new Application_Form_Login();
	        $this->view->form = $form;
    	}

    }


}

