<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initSetupBaseUrl() {
	    $this->bootstrap('frontcontroller');
	    $controller = Zend_Controller_Front::getInstance();
	    $controller->setBaseUrl('/ZendProject/SLMS/public'); 
	}
	protected function _initPlaceholders()
	{
		$this->bootstrap('layout');
	    $layout = $this->getResource('layout');
	    $view = $layout->getView();
	    $view->doctype('XHTML1_STRICT');
	    $view->headMeta()->appendName('keywords', 'framework, PHP')->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
		// Set the initial title and separator:
		$view->headTitle('SLMS Site')->setSeparator(' :: ');
		// Set the initial stylesheet:
		$view->headLink()->prependStylesheet($view->baseUrl().'/css/bootstrap.min.css');
		// Set the initial JS to load:
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery-1.12.3.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/bootstrap.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/code.js');
	}
	//To activate session
	/*protected function _initSession(){
		Zend_Session::start();
	}*/
}

