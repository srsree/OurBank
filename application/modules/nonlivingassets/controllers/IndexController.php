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
?>

<?php 
class Nonlivingassets_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
//it is create session and implement ACL concept...
        $this->view->pageTitle=$this->view->translate('Non living assets');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//             $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

//add family health add action
    public function addassetAction() 
    {
        $this->view->title = $this->view->translate("Add nonliving asset details");
        $this->view->memberid=$member_id=$this->_getParam('id');

        $this->view->submoduleid = $this->_getParam('subId');
//get all type of living assets
        $asset_model=new Nonlivingassets_Model_nonlivingassets();
//set the value of living assets drop down box...
        $this->view->nonliveasset_details = $this->view->adm->viewRecord("ourbank_master_nonliveassets","id","DESC");

        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
            {
            $number = $this->_getParam('number');
            $value = $this->_getParam('value');
            $submoduleid = $this->_getParam('subid');
            $i = 0;
            foreach($this->_getParam('assettype') as $val) {
                $assettype = array('submodule_id' => $submoduleid,
                                    'member_id' => $member_id,
                                    'nonliveasset_id' => $val,
                                    'number'=>$number[$i],
                                    'value'=>$value[$i]);
                $i++;
                $this->view->adm->addRecord("ourbank_nonlivingassetsdetails",$assettype);
            }
             $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }

    public function editassetAction() 
    {
        $this->view->title=$this->view->translate('Edit Livingasset');
        $this->view->memberid=$member_id=$this->_getParam('id');
        //load form for living assets
        $this->view->submoduleid = $this->_getParam('subId');
         //dynamically change the path name
       
         //get all type of living assets
        $this->view->nonliveasset_details = $this->view->adm->viewRecord("ourbank_master_nonliveassets","id","DESC");
         //update contact details
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $id=$this->_getParam('id');
            $submoduleid=$this->_getParam('subid');
            $asset_db = new Nonlivingassets_Model_nonlivingassets ();
            $editAsset = $asset_db->getAssetdetails($id);
            for ($j = 0 ; $j< count($editAsset); $j++) {
                $this->view->adm->addRecord("ourbank_nonlivingassetsdetails_log",$editAsset[$j]);
            }
            $asset_db->deleteasset($id);
            $number = $this->_getParam('number');
            $value = $this->_getParam('value');
            $i = 0;
            foreach($this->_getParam('assettype') as $val) {

                $assettype = array('submodule_id' => $submoduleid,
                                    'member_id' => $id,
                                    'nonliveasset_id' => $val,
                                    'number'=>$number[$i],
                                    'value'=>$value[$i]);
                $i++;
                $this->view->adm->addRecord("ourbank_nonlivingassetsdetails",$assettype);
            }
            $this->_redirect('/individualmcommonview/index/commonview/id/'.$id);
        } 
        else {
            //set the contact details in the contact form...
            $sub_id=$this->_getParam('subId');
            $id=$this->_getParam('id');
            $individualcommon=new Individualmcommonview_Model_individualmcommonview();
            $this->view->editAsset = $individualcommon->getnonlivingassetsdetails($id); 
            //$form->populate($editContact[0]);
        }

    }
}
