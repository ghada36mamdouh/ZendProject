<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $URL=Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $URL=$URL."auth/login";
        $this->setAction($URL);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email: *');
        $email->setRequired(true);
        $email->setAttrib('class','form-control');
                
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password: *');
        $password->setRequired(true);
        $password->setAttrib('class','form-control');
                
        $signin = new Zend_Form_Element_Submit('Login');
        $signin->setLabel('Sign in');														
        $signin->setAttrib('class','btn-primary btn form-control');

                
        $this->addElements(array(
                        $email,
                        $password,
                        $signin,
        ));
    }


}

