<?php

class Application_Form_AddMatrial extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $basePath = Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl();
        $URL=$basePath."/Matrial/add";
       // $this->setAction($URL);
        $this->setAttrib('class', 'form-horizontal') ;
        $this->setAttrib('role', 'form') ;

        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('Matrial description :');
        $description->setRequired(true);
        $description->setAttrib('class','form-control col-sm-8 input');



        $file = new Zend_Form_Element_File('path');
        $file->setLabel('Upload Matrial :');
        $file->setAttrib('id', 'path') ;
        $file->setDestination(__DIR__.'/../../public/uploadedMatrials') ;
        // $file->addValidator('extension', true, array('mp4','doc','pdf','ppt','zip')) ;
        // $file->setValueDisabled(true);
            //->addValidator('Size', false, 10240000)          
        $file->setRequired(true);
        //$file->setAttrib('class','btn-default');


        $type = new Zend_Form_Element_Hidden('type');
        $course_id = new Zend_Form_Element_Hidden('course_id');
        $hiddenpath = new Zend_Form_Element_Hidden('hiddenpath');
               

        $add = new Zend_Form_Element_Submit('add');
        $add->setLabel('add');														
        $add->setAttrib('class','btn-primary btn form-control');
             // col-sm-2  col-sm-offset-2
        $this->addElements(array(
                        $type,
                        $description,
                        $file,
                        $hiddenpath,
                        $course_id,
                        $add,
        ));
    }



}

