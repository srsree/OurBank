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

<!--
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
!-->
<?php
class Branch_IndexController extends Zend_Controller_Action {
    public function init() {

        $this->view->pageTitle='Bank Name';
     // $this->view->myaccountmodule = "current";
    }

//This function is used get bank name and store in the drop down list box
    public function indexAction() {
        $this->view->title = "Bank";
//      $this->view->accountinfolink="newcurrent";
        $addForm = new Branch_Form_Branch();
        $this->view->form=$addForm;
        $branch= new Branch_Model_branch();
        $subBranch = $branch->getBranchOffice();
        foreach($subBranch as $subBranch) {
        $addForm->office->addMultiOption($subBranch['bank_id'],$subBranch['bankname']);
        }
        }

}
