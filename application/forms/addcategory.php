<?php

class Application_Form_addcategory extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $URL="../Category/add";
        $this->setAction($URL);
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:');
        $name->setAttrib('class','form-control');
        $name->setRequired(true);
        
        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('description:');
        $description->setAttrib('class','form-control');
        $description->setRequired(true);
        
                
        $register = new Zend_Form_Element_Submit('Add Category');
        $register->setLabel('Add Category');
        $register->setAttrib('class','btn-primary btn form-control');
                
        $this->addElements(array(
                        $name,
                        $description,
                        $register,
        ));
    }


}

