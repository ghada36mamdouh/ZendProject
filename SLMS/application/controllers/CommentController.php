<?php

class CommentController extends Zend_Controller_Action
{
	private $model =null ;
    public function init()
    {
        $this->model =  new Application_Model_DbTable_Comment ();

        // $authorization =Zend_Auth::getInstance();
        // if(!$authorization->hasIdentity()) {
        //     $this->redirect('/');      
        // }
        // $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        // $this->$user=$authNamespace->user;
        // $this->view->user= $this->$useruser;                  
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction()
    {   
        $cid = $this->getRequest()->getParam('cid');
    	$mid = $this->getRequest()->getParam('mid');
    	$type = $this->getRequest()->getParam('type');

    	if($this->getRequest()->isPost()){
           $body = $this->getRequest()->getPost('commentbody');
           if(!empty($body)){
           			$data['body'] = $body ;
           			$data['mid'] = $mid ;
           			//$data['uid'] = $this->user['id'] ;  
           			$data['uid'] = 1 ; //check 
           	        $this->model->addComment($data);
                    //$this->view->addcommentform = $data ;
           	 }
        }  
        $this->redirect('/Matrial?cid='.$cid.'&type='.$type) ;
    }
    public function deleteAction()
    {   
        $cid = $this->getRequest()->getParam('cid');
        $comid = $this->getRequest()->getParam('comid');
    	$type = $this->getRequest()->getParam('type');
        $this->model->deleteComments($comid);	
        $this->redirect('/Matrial?cid='.$cid.'&type='.$type) ;
    }
}

