<?php

class Application_Form_addcourse extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $URL="../Course/add";
        $this->setAction($URL);
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:');
        $name->setAttrib('class','form-control');
        $name->setRequired(true);
        
        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('description:');
        $description->setAttrib('class','form-control');
        $description->setRequired(true);
         
        $logo = new Zend_Form_Element_File('logo');
        $logo->setLabel('Upload an logo:');
        $logo->setDestination('images');
        $logo->setRequired(true);
        $logo->addValidator('Count', false, 1);               
        $logo->addValidator('Size', false, 10240000);            
        $logo->addValidator('Extension', false, 'jpg,jpeg,png');

        $register = new Zend_Form_Element_Submit('Add Course');
        $register->setLabel('Add Course');
        $register->setAttrib('class','btn-primary btn form-control');
        $cid = new Zend_Form_Element_Hidden('cid');
                
        $this->addElements(array(
                        $name,
                        $description,
                        $logo,
                        $cid,
                        $register,
        ));
    }


}

