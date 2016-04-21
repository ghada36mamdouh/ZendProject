<?php

class Application_Form_AddMatrial extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $basePath = Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl();
        $URL=$basePath."/Matrial/add";
        $this->setAction($URL);

        $type = new Zend_Form_Element_Select('type');
		$type ->setLabel('Matrial type: ');
		$type->addMultiOptions(array(
				'pdf' => 'pdf',
				'word' => 'word',
				'ppt' => 'power point',
				'vedio' => 'vedio',
			));
		// $type->setAttrib('class','form-control');

        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('Matrial description :');
        $description->setRequired(true);
        //$description->setAttrib('class','form-control');

        $file = new Zend_Form_Element_File('path');
        $file->setLabel('Upload Matrial');
        $file->setAttrib('id', 'path') ;
        $file->setDestination(__DIR__.'/../../public/uploadedMatrials') ;
            //->addValidator('extension', true, array('.mp4','docx','pdf','txt'))
            //->addValidator('Size', false, 10240000)           
            //->setRequired(false);
        $course_id = new Zend_Form_Element_Hidden('course_id');

                
        $add = new Zend_Form_Element_Submit('add');
        $add->setLabel('add');														
        // $add->setAttrib('class','btn-primary btn form-control');
             
        $this->addElements(array(
                        $type,
                        $description,
                        $file,
                        $course_id,
                        $add,
        ));
    }



}

