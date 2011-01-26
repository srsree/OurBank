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
class Productcommonview_IndexController extends Zend_Controller_Action
{
	public function init() 
	{
		$this->view->pageTitle='Product';
//         $globalsession = new App_Model_Users();
//         $this->view->globalvalue = $globalsession->getSession();
// 		$this->view->createdby = $this->view->globalvalue[0]['id'];
// 		$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
		$this->view->adm = new App_Model_Adm();   	
	}

	public function indexAction() 
	{
           
	}
	public function categoryaddAction() 
	{
		
		
	}
	
	public function categoryeditAction() 
	{
    }		
	public function productviewAction() 
	{
		//Acl
        $id=$this->_request->getParam('id');
			
			$product= new Product_Model_Product;
			$this->view->productdetails=$product->getProduct($id);
	}	
	public function categorydeleteAction() 
	{

}
}
