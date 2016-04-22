<?php

class RequestController extends Zend_Controller_Action
{
	private $requestModel=null;

    public function init()
    {
        $this->requestModel=new Application_Model_DbTable_Request();

        $this->request = new Application_Model_DbTable_Request();
   
    }

    public function indexAction()
    {
        $this->view->r=$this->requestModel->listRequestsandUsers();
    }

    public function sendAction()
    {
        $form = new Application_Form_Request();
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                $this->request->addRequest($data);
                $this->redirect('/');
            }
        }

    }


}

