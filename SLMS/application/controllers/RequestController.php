<?php

class RequestController extends Zend_Controller_Action
{
	private $requestModel=null;

    public function init()
    {
        $this->requestModel=new Application_Model_DbTable_Request();
    }

    public function indexAction()
    {
        $this->view->r=$this->requestModel->listRequestsandUsers();
    }


}

