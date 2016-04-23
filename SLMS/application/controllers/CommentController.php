<?php

class CommentController extends Zend_Controller_Action
{
    private $model =null ;
    public function init()
    {
        $this->model =  new Application_Model_DbTable_Comment ();
        $this->matrialModel = new Application_Model_DbTable_Material() ;

        $this->categories=new Application_Model_DbTable_Category();

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

    function delAction()
    {
        $LoginedUser=Zend_Auth::getInstance();
        if($LoginedUser->hasIdentity())
        {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $this->view->user=$authNamespace->user;
            $this->view->logged=True;
            $this->view->categories=$this->categories->listCategories();

            $mid=$this->getRequest()->mid;
            echo $mid;
            $cmid=$this->getRequest()->cmid;
            $type = $this->getRequest()->type;

            $matrials=$this->matrialModel->getMaterialById($mid);
            $this->view->materials=$matrials[0];

            $this->model->deleteComments($cmid);
            $comments=$this->model->listMaterialComments($mid);
            $this->view->comments=$comments;
            $this->redirect('/Matrial/indetails/?mid='.$mid.'&type='.$type) ;



        }
        else
        {
            $logInform = new Application_Form_Login();
            $this->view->loginform = $logInform;

            $registform = new Application_Form_Regist();
            $this->view->registform = $registform;
        }
    }

     public function editAction()
    {   
        $cid = $this->getRequest()->getParam('cid');
        $comid = $this->getRequest()->getParam('comid');
        $type = $this->getRequest()->getParam('type');

        if($this->getRequest()->isPost()){
           $body = $this->getRequest()->getPost('commentbody');
           if(!empty($body)){
                    $data['body'] = $body ;
                    $this->model->editComment($comid,$data);
            }
            $this->redirect('/Matrial?cid='.$cid.'&type='.$type.'&editComId=') ;
        }else{
            $this->redirect('/Matrial?cid='.$cid.'&type='.$type.'&editComId='.$comid) ;
        } 

    }
}

