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
class Commonviewfee_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle="Fee";
        $sessionName = new Zend_Session_Namespace('ourbank');
        echo $this->view->createdby = $sessionName->primaryuserid;
    }

    public function indexAction() {
$addForm = new Commonviewfee_Form_Feedetails();
                        $this->view->form=$addForm;
$appliesTo = new Feecommon_Model_Feecommon();
        $appliesTo = $appliesTo->getAppliesTo();
        foreach($appliesTo as $appliesTo) {
                $addForm->membertype->addMultiOption($appliesTo['membertype_id'],$appliesTo['membertype']);
				}

        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
 //$uptodate=$this->_getParam('holidayupto');echo "<h1>".$uptodate."</h1>";
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                
                if ($addForm->isValid($formData)) {     

		
		$feeame= new Commonviewfee_Model_Setting();
$dbAdapter = Zend_Db_Table::getDefaultAdapter();
				$data['fee_id']='';
				$dbAdapter->insert('ob_fees', $data);
				$fee_id = Zend_Db_Table::getDefaultAdapter()->lastInsertId('ob_fees','fee_id');
				echo $createdby = $this->view->createdby;

		$feeame->insertFee($addForm->getValues(),$createdby,$fee_id);
		 $this->_redirect('/fee');

                }}
}}
}
