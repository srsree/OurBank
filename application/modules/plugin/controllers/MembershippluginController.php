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
class Plugin_MembershippluginController extends Zend_Controller_Action 
{
    public function init()
     {
        $this->view->pageTitle='Membership Plug ins';
     }

    public function indexAction() 
    {   
        $this->view->title='Membership Plugins';
      	$storage = new Zend_Auth_Storage_Session();
	$data = $storage->read();
	if(!$data)
        {
		$this->_redirect('index/login');
	}
          $plugin_view = new Plugin_Model_memberplugin();
        //display all the views
         $plugin_detail= $plugin_view->fetch_all_detail();
       //  print_r($plugin_detail);
         $this->view->plugin_details = $plugin_view->fetch_all_detail();
     }

    public function updatepluginAction()
    {
          $plugin_view = new Plugin_Model_memberplugin();
        //display all the views
         $plugin_detail= $plugin_view->fetch_all_detail();
       //  print_r($plugin_detail);
         $this->view->plugin_details = $plugin_view->fetch_all_detail();
         $rootid = (int)$this->_getParam('rootid');
         $status = (int)$this->_getParam('status');
         $plugin_update = new Plugin_Model_memberplugin();
         $result=$plugin_update->updateModule($rootid,$status);
    }

}



