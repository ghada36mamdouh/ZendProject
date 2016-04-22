<?php

class Application_Form_Regist extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $URL=Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $URL=$URL."auth/signup";
        $this->setAction($URL);

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:');
        $name->setAttrib('class','form-control');
        $name->setRequired(false);
        $name->setAttrib('placeholder',"Enter name");
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email: *');
        $email->setAttrib('class','form-control');
        $email->setAttrib('type','email');
        $email->setAttrib('placeholder',"Enter email");
        $email->setRequired(false); 
		$email->addValidator('EmailAddress');
                
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password: *');
        $password->setAttrib('class','form-control');
        $password->setRequired(true);
        $password->setAttrib('placeholder',"Enter password");
                
        $confirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password: *');
        $confirmPassword->setAttrib('class','form-control');
        $confirmPassword->setRequired(true);
        $confirmPassword->setAttrib('placeholder',"Confirm password");

        $gender = new Zend_Form_Element_Radio('gender');
        $gender->setLabel('Gender :');
        $gender->setRequired(true);
        $gender->setSeparator('');
        $gender->setMultiOptions(array('male' => 'Male ','Female' => 'female'));
        $gender->addErrorMessage('Please select male or female.');
        $gender->addValidator('NotEmpty');

		$country = new Zend_Form_Element_Select('country');

		$country ->setLabel('Countries :');

		$country->addMultiOptions(array(

				'US' => 'United States',

				'UK' => 'United Kingdom',

				'EG' => 'Egypt'

			));
        $country->setAttrib('class','form-control');
                
        $register = new Zend_Form_Element_Submit('Register');
        $register->setLabel('Sign up');
        $register->setAttrib('class','btn-primary btn form-control');
        
        $photo = new Zend_Form_Element_File('photo');
		$photo->setLabel('Upload an photo:');
		$photo->setDestination('images');
		$photo->setRequired(true);
		$photo->addValidator('Count', false, 1);               
		$photo->addValidator('Size', false, 10240000);            
		$photo->addValidator('Extension', false, 'jpg,jpeg,png');

		$signature = new Zend_Form_Element_Text('signature');
        $signature->setLabel('Signature :');
        $signature->setAttrib('class','form-control');
        $signature->setRequired(false);
        $signature->setAttrib('placeholder',"Enter signature");

        $this->addElements(array(
                        $name,
                        $email,
                        $password,
                        $confirmPassword,
                        $gender,
                        $country,
                        $photo,
                        $signature,
                        $register,
        ));
    }


}

