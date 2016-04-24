<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->categories=new Application_Model_DbTable_Category();
       
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
            $this->view->categories=$this->categories->listCategories();
            /*
            var_dump($requestForm);*/

        }
        else
        {
            $logInform = new Application_Form_Login();
            $this->view->loginform = $logInform;

            $registform = new Application_Form_Regist();
            $registform->removeElement('photo');
            $this->view->registform = $registform;
        }

    }


}

