<?php

class Application_Form_adduser extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $URL="../User/add";
        $this->setAction($URL);
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:');
        $name->setAttrib('class','form-control');
        $name->setRequired(false);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email: *');
        $email->setAttrib('class','form-control');
        $email->setRequired(false);
                
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password: *');
        $password->setAttrib('class','form-control');
        $password->setRequired(true);
                
        $confirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password: *');
        $confirmPassword->setAttrib('class','form-control');
        $confirmPassword->setRequired(true);

        $gender = new Zend_Form_Element_Radio('gender');
        $gender->setLabel('Gender :');
        $gender->setRequired(true);
        $gender->setSeparator('');
        $gender->setMultiOptions(array('Male' => 'male ','Female' => 'female'));
        $gender->addErrorMessage('Please select male or female.');
        $gender->addValidator('NotEmpty');

		$country = new Zend_Form_Element_Select('country');

		$country ->setLabel('Countries :');

		$country->addMultiOptions(array(

				'US' => 'United States',

				'UK' => 'United Kingdom',

				'EG' => 'Egypt'

			));
        $type = new Zend_Form_Element_Select('type');
        $type->setAttrib('class','form-control');
        $type = new Zend_Form_Element_Select('type');

        $type ->setLabel('type :');

        $type->addMultiOptions(array(
                'Admin' => 'admin',
                'Regular' => 'regular'
            ));
        $type->setAttrib('class','form-control');
                
        $register = new Zend_Form_Element_Submit('Add User');
        $register->setLabel('Add User');
        $register->setAttrib('class','btn-primary btn form-control');
                
        $this->addElements(array(
                        $name,
                        $email,
                        $password,
                        $confirmPassword,
                        $gender,
                        $country,
                        $type,
                        $register,
        ));
    }


}

