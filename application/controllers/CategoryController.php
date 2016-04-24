<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        $this->categoryModel=new Application_Model_DbTable_Category();
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
       if($this->getRequest()->isPost()){
            $name = $this->getRequest()->getParam('name');
            $description = $this->getRequest()->getParam('description');
            $data['name']=$name;
            $data['description']=$description;
            $this->categoryModel->addCategory($data);   
        }
        $this->redirect('Admin/list-categories');
    }

    public function editAction()
    {  
        $id = $this->getRequest()->getParam('id');
        if($id){
            if($this->getRequest()->isPost()){
                $name = $this->getRequest()->getParam('name');
                $description = $this->getRequest()->getParam('description');
                $data['name']=$name;
                $data['description']=$description;
                $this->categoryModel->editCategory($id, $data);    
            }
        }
        $this->redirect('Admin/list-categories');
    }

    public function deleteAction()
    {  
        $id = $this->getRequest()->getParam('id');
        if($id){
            $this->categoryModel->deleteCategory($id);
        }
        $this->redirect('Admin/list-categories');
    }


}

