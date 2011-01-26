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
/*
 *  Age Report controller to view
 */
class Agereport_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->pageTitle = $this->view->translate("Age Ratio Wise Report");
	$this->view->type = $this->view->translate('others');
	//session
	$sessionName = new Zend_Session_Namespace('ourbank');
        $userid=$this->view->createdby = $sessionName->primaryuserid;
	//user login instance
        $login=new App_Model_Users();
        $loginname=$login->username($userid);
        foreach($loginname as $loginname) 
	{
          $this->view->username=$loginname['username'];
        }
    }

	//view action
    public function indexAction()
    {
        
        $this->view->from1=$from_age=16;
        $this->view->to1=$to_age=25;
        $age_ratio=new Agereport_Model_agereport();
        $age_result1=$age_ratio->getage_between($from_age,$to_age);
	//view instance
        $this->view->age_ratio1=$age_result1;

        $this->view->from2=$from_age=26;
        $this->view->to2=$to_age=35;
        $age_result2=$age_ratio->getage_between($from_age,$to_age);
        $this->view->age_ratio2=$age_result2;

        $this->view->from3=$from_age=36;
        $this->view->to3=$to_age=45;
        $age_result3=$age_ratio->getage_between($from_age,$to_age);
        $this->view->age_ratio3=$age_result3;

        $this->view->from4=$from_age=46;
        $this->view->to4=$to_age=60;
        $age_result4=$age_ratio->getage_between($from_age,$to_age);
        $this->view->age_ratio4=$age_result4;

        $this->view->age=$age=60;
        $age_result5=$age_ratio->getage_above($age);
        $this->view->age_ratio5=$age_result5;
    }
}
