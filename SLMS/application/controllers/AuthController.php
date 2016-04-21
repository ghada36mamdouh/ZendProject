<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->identity = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
        $users = new Application_Model_DbTable_User();
        $form = new Application_Form_Login();

        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'users');
                $authAdapter->setIdentityColumn('email');
                $authAdapter->setCredentialColumn('password');
                $authAdapter->setIdentity($data['email']);
                $authAdapter->setCredential(md5($data['password']));
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $storage = new Zend_Auth_Storage_Session();

                    $loginedUser=$users->getUserByEmail($data['email']);
                    $authNamespace = new Zend_Session_Namespace('Zend_Auth');
                    $authNamespace->user = $loginedUser;
                    $this->redirect('/');
                } else {
                    $this->view->errorMessage = "Invalid username or password. Please try again.";
                }         
            }
        }
    }

    public function signupAction()
    {
        // action body
        $users = new Application_Model_DbTable_User();
        $form = new Application_Form_Regist();

        if($this->getRequest()->isPost()){
            
            if($form->isValid($_POST)){
                $data = $form->getValues();
                if($data['password'] != $data['confirmPassword']){
                    $this->view->errorMessage = "Password and confirm password don't match.";
                    return;
                }
                if($users->checkUnique($data['email'])){
                    $this->view->errorMessage = "Email already taken. Please choose another one.";
                    return;
                }
                unset($data['confirmPassword']);

                $users->addUser($data);/*
                $users->sendConfirmationMail($data);*/
                
                $this->redirect('/');
            }
        }
    }

    public function homeAction()
    {
        // action body
        $LoginedUser=Zend_Auth::getInstance();
        if($LoginedUser->hasIdentity())
        {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $this->view->user=$authNamespace->user;
            $this->view->logged=True;


            $users = new Application_Model_DbTable_User();
            $user=$users->getUserById($authNamespace->user['id']);
            $form = new Application_Form_Regist();
            $form->removeElement('password');
            $form->removeElement('confirmPassword');

            $form->populate($user[0]);
            $this->view->editform=$form;
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function logoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $authorization =Zend_Auth::getInstance();
        $authorization->clearIdentity();
        $this->_redirect('/');
    }

}









