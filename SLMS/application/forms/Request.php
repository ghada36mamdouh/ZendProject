<?php

class Application_Form_Request extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        $authNamespace->user;


        $URL=Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $URL=$URL."request/send";
        $this->setAction($URL);

        $note = new Zend_Form_Element_Text('body');
        $note->setLabel('Note:');
        $note->setAttrib('class','form-control');
        $note->setRequired(false);
        $note->setAttrib('placeholder',"Enter your notes .. ");
        
        $courseID = new Zend_Form_Element_Select('course_id');
        $courseID ->setLabel('This request for Course :');
        $courseID->addMultiOption(0,'Choose Course ..');
        $courses = new Application_Model_DbTable_Course();
        foreach ($courses->fetchAll() as $course) {
            $courseID->addMultiOption($course['id'],$course['name']);
        }
        $courseID->setAttrib('class','form-control');


        $uid = new Zend_Form_Element_Text('uid');
        $uid->setAttrib('class','hidden');
        $uid->setValue($authNamespace->user['id']);

        
        $register = new Zend_Form_Element_Submit('Send');
        $register->setLabel('Send');
        $register->setAttrib('class','btn-primary btn form-control');
        
        $this->addElements(array(
                        $note,
                        $courseID,
                        $uid,
                        $register,
        ));
    }


}

