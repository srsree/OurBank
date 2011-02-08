<?php
class settings_IndexController extends Zend_Controller_Action {
public function init() {
        $this->view->pageTitle='Settings';
    }

    public function indexAction() {
	
	$settingsForm = new settings_Form_Settings();
	$this->view->form = $settingsForm;
	
	   $settingModel=new settings_Model_Setting();
	   $allLanguage=$settingModel->fetchAllLanguage();
	   foreach($allLanguage as $eacharraysent) {
	   $this->view->form->languages->addMultiOption($eacharraysent->language_id,$eacharraysent->langauge_name);
	   }



    }
   
}

