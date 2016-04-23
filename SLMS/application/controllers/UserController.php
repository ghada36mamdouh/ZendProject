<?php

class UserController extends Zend_Controller_Action
{   
    protected $userModel=null;

    public function init()
    {
        /* Initialize action controller here */
        $this->userModel=new Application_Model_DbTable_User();
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
        $form = new Application_Form_Regist();
        if($this->getRequest()->isPost()){
            $form->removeElement('photo');
            $form->removeElement('confirmPassword');
            $form->removeElement('signature');
            if($form->isValid($_POST)){
                $data=$this->getRequest()->getParams();
                $this->userModel->addUser($data); 
                $this->redirect('Admin/list-users'); 
            }
        }
        $this->redirect('Admin/add-user');
       
    }
    public function editAction()
    {  
        $id = $this->getRequest()->getParam('id');
        if($id){
            if($this->getRequest()->isPost()){
                $name = $this->getRequest()->getParam('name');
                $email = $this->getRequest()->getParam('email');
                $type = $this->getRequest()->getParam('type');
                $gender = $this->getRequest()->getParam('gender');
                $country = $this->getRequest()->getParam('country');
                $isvalid = $this->getRequest()->getParam('isvalid');
                $data['name']=$name;
                $data['email']=$email;
                $data['type']=$type;
                $data['gender']=$gender;
                $data['country']=$country;
                $data['isvalid']=$isvalid;
                $this->userModel->editUser($id, $data);    
            }
        }
        $this->redirect('Admin/list-users');
    }
    public function deleteAction()
    {  
        $id = $this->getRequest()->getParam('id');
        if($id){
         if ($this->userModel->deleteUser($id))
            $this->redirect('Admin/list-users');
        } else {
            $this->redirect('Admin/list-users');
        }
    }
    public function banAction()
    {
        $id = $this->getRequest()->getParam('id');
        $validate = $this->getRequest()->getParam('validate');
        if($id){
            if($validate==1)
                $data['isvalid']=0;
            else
                $data['isvalid']=1;
            $this->userModel->editUser($id, $data);
        }   
        $this->redirect('Admin/list-users');
    }
    public function changetypeAction()
    {
        $id = $this->getRequest()->getParam('id');
        $type = $this->getRequest()->getParam('type');
        if($id){
            $data['type']=$type;
            $this->userModel->editUser($id, $data);
        }   
        $this->redirect('Admin/list-users');
    }

    
    
}

