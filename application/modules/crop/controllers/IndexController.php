<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/

class crop_IndexController extends Zend_Controller_Action{

    public function init() 
	{
        $this->view->pageTitle=$this->view->translate('Membership');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
	$this->view->createdby = $this->view->globalvalue[0]['id'];
        //$this->view->username = $this->view->globalvalue[0]['username'];
        //if (($this->view->globalvalue[0]['id'] == 0)) {
            //$this->_redirect('index/logout');
        //}
        //getting module name and change the side bar dynamically 
        $this->view->id=$subId=$this->_getParam('id');
        $this->view->subId=$subId=$this->_getParam('subId');
        $this->view->modId=$modId=$this->_getParam('modId');
        $addressmodel=new Individualmcommonview_Model_individualmcommonview();
        $module_name=$addressmodel->getmodule($subId);
        foreach($module_name as $module_view)
        {
            $address=$module_view['module_description'];
        }
        $this->view->pageTitle='Individual crop details';
        $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

    public function addcropAction() 
    {
        $this->view->title=$this->view->translate('Add Crop');
        //load contact details form with two arguments ...
        $form = new Crop_Form_Crop($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->memberid=$member_id=$this->_getParam('id');

        $this->view->form=$form;
        $this->view->submitform = new Bank_Form_Submit();
        //dynamically change the path name
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view) {
            $path1=$module_view['module_description'].'commonview';
        }
        $path1= $this->view->path1=strtolower($path1);

        $funder = $this->view->adm->viewRecord("ourbank_crop","id","DESC");
	foreach($funder as $funder) {
	   $form->crop_id->addMultiOption($funder['id'],$funder['name']);
	}

	$crop = new Crop_Model_Crop ();
	$this->view->cropdetails = $crop->getCrop();
        if ($this->_request->getPost('submit')) {
            $acer=$this->_getParam('acre');
            $quantity=$this->_getParam('quantity');
            $marketed=$this->_getParam('marketed');
            $price=$this->_getParam('price');
            $i = 0;
            foreach($this->_getParam('crop_id') as $val) {
                $crop = array('member_id' => $member_id,
                              'crop_id' => $val,
                              'acre' => $acer[$i],
                              'quantity' => $quantity[$i],
                              'marketed'=>$marketed[$i],
                              'price'=>$price[$i]);
                $i++;
                $this->view->adm->addRecord("ourbank_cropdetails",$crop);
            }
            $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }
    
    //editing contact details
    public function editcropAction() 
    {
        $this->view->title=$this->view->translate('Edit Contact');
        //load contact details form with two arguments ...
        $form = new Crop_Form_Crop($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->form = $form;
        $this->view->id = $this->_getParam('id');
        $this->view->submitform = new Bank_Form_Submit();
        //dynamically change the path name
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view)
        {$path1=$module_view['module_description'].'commonview';}
        $path1= $this->view->path1=strtolower($path1);
	$crop = new Crop_Model_Crop ();
	$this->view->cropdetails = $crop->getCrop();
        //update contact details
        if ($this->_request->getPost('submit')) {
        
            $id=$this->_getParam('id');
            $crop = new Crop_Model_Crop ();
            $editCrop = $crop->getCropdetails($id);
            for ($j = 0 ; $j< count($editCrop); $j++) {
                $this->view->adm->addRecord("ourbank_cropdetails_log",$editCrop[$j]);
            }
            $crop->deletecrop($id);
            $acer=$this->_getParam('acre');
            $quantity=$this->_getParam('quantity');
            $marketed=$this->_getParam('marketed');
            $price=$this->_getParam('price');
            $i = 0;
            foreach($this->_getParam('crop_id') as $val) {
                $crop = array('member_id' => $id,
                              'crop_id' => $val,
                              'acre' => $acer[$i],
                              'quantity' => $quantity[$i],
                              'marketed'=>$marketed[$i],
                              'price'=>$price[$i]);
                $i++;
                $this->view->adm->addRecord("ourbank_cropdetails",$crop);
            }
            $this->_redirect('/individualmcommonview/index/commonview/id/'.$id);
        } else {
            //set the contact details in the contact form...
            $sub_id=$this->_getParam('subId');
            $id=$this->_getParam('id');
            $individualcommon=new Individualmcommonview_Model_individualmcommonview();
            $this->view->editCrop = $individualcommon->getcrop($this->_getParam('id'));
        }
    }
}
