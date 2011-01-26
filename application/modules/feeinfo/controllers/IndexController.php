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
class Feeinfo_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle='Fee info';
        $sessionName = new Zend_Session_Namespace('ourbank');
        $this->view->createdby = $sessionName->primaryuserid;
    }

    public function indexAction() {
               
$feeinfoForm = new Feeinfo_Form_Settings();
        $this->view->form = $feeinfoForm;
 if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
 //$uptodate=$this->_getParam('holidayupto');echo "<h1>".$uptodate."</h1>";
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                
                if ($feeinfoForm->isValid($formData)) {  
			       $feename=$this->_getParam('feename'); 
			       $feeamount=$this->_getParam('feeamount'); 
			       $feedescription=$this->_getParam('feedescription'); 

				$model = new Feeinfo_Model_Setting();
				$dbAdapter = Zend_Db_Table::getDefaultAdapter();
				$data['fee_id']='';
				$dbAdapter->insert('ourbank_fees', $data);
				$fee_id = Zend_Db_Table::getDefaultAdapter()->lastInsertId('ourbank_fees','fee_id');
                    		$createdby = $this->view->createdby;
 $model = new Feeinfo_Model_Setting();
				                $model->insertFee($feeinfoForm->getValues(),$createdby);

}}}

    }

}
