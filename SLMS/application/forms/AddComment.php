<?php

class Application_Form_AddComment extends Zend_Form
{

    public function init()
    {
        // $basePath = Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl();
        // $URL=$basePath."/Matrial/add";
        // $this->setAction($URL);

        $body = new Zend_Form_Element_Text('body');
        $body->setRequired(true);
        //$body->setAttrib('class','form-control');
        $uid = new Zend_Form_Element_Hidden('uid');
        $mid = new Zend_Form_Element_Hidden('mid');              
        $add = new Zend_Form_Element_Submit('add');
        $add->setLabel('add');														
        // $add->setAttrib('class','btn-primary btn form-control');            
        $this->addElements(array($body,$uid,$mid,$add,));

    }


}

