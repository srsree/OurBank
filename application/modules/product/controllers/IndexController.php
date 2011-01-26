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
class Product_IndexController extends Zend_Controller_Action
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
               
		$this->view->title = "Product";
// 		$storage = new Zend_Auth_Storage_Session();
// 		$data = $storage->read();
// 		if(!$data){
// 			$this->_redirect('index/login');
// 		}
		$product = new Product_Model_Product();
		$categorydetails=$product->getProductinformation();
// 		$this->view->changelog=$category->getUpdatesinformation();
		$searchForm = new Product_Form_Search();
		$this->view->form = $searchForm;
		$category_id = $product->getCategoryDetails();

$institution = $this->view->adm->viewRecord("ourbank_category","id","DESC");

			foreach($institution as $institution) {
				$searchForm->category_id->addMultiOption($institution['id'],$institution['name']);
			}


		$result = $product->getCategoryDetails();
		$page = $this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($result);
		$paginator->setItemCountPerPage(5);
		$paginator->setCurrentPageNumber($page);

		$this->view->paginator = $paginator;
		if ($this->_request->isPost() && $this->_request->getPost('Search')){
			if ($this->_request->isPost()){
				if ($searchForm->isValid($this->_request->getPost())){
					$result = $product->SearchProduct($searchForm->getValues());
					$page = $this->_getParam('page',1);
					$paginator = Zend_Paginator::factory($result);
					$paginator->setItemCountPerPage(5);
					$paginator->setCurrentPageNumber($page);
					$this->view->paginator = $paginator;
				}
			}
		}
	}
	public function productaddAction() 
	{
		
		$productForm = new Product_Form_Product();
		$this->view->form = $productForm;
$categoryname = $this->view->adm->viewRecord("ourbank_category","id","DESC");
			foreach($categoryname as $categoryname){
				$productForm->category_id->addMultiOption($categoryname['id'],$categoryname['name']);
			}
		if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
				$formData = $this->_request->getPost();
				if ($this->_request->isPost()) {
					if ($productForm->isValid($formData)) {  
					$id = $this->view->adm->addRecord("ourbank_product",$productForm->getValues());
						$this->_redirect('/productcommonview/index/productview/id/'.$id);
				}
			}
		}
		
	}
	
	public function producteditAction() 
	{
			$productForm = new Product_Form_Product();
			$this->view->form = $productForm;
			$id=$this->_getParam('id');
						$this->view->id = $id;

			$productname = $this->view->adm->viewRecord("ourbank_category","id","DESC");
			foreach($productname as $productname){
				$productForm->category_id->addMultiOption($productname['id'],$productname['name']);
			}
			$product = new Product_Model_Product;
			$productdetails = $product->getProduct($id);
			$productForm->populate($productdetails[0]);
			if ($this->_request->isPost() && $this->_request->getPost('Update')) {  
				$id = $this->_getParam('id');
				$formData = $this->_request->getPost();
				//print_r($formData);
				if ($productForm->isValid($formData)) { 
					$previousdata = $this->view->adm->editRecord("ourbank_product",$id);
					$this->view->adm->updateLog("ourbank_product_log",$previousdata,1);
					//update 					
					$this->view->adm->updateRecord("ourbank_product",$id,$productForm->getValues());
					$this->_redirect('product/index/');
				}
 			}
    }		

	public function productdeleteAction() 
	{

 		$delform = new Product_Form_Delete();
			$this->view->deleteform = $delform;
			$id = $this->_getParam('id');
			$this->view->id = $id;
			
			$product= new Product_Model_Product;
			$this->view->productdetails=$product->getProduct($id);
// 			}
			if($this->_request->isPost() && $this->_request->getPost('DELETE')) {
			$formdata = $this->_request->getPost();
				if ($delform->isValid($formdata)) { 
 $redirect = $this->view->adm->deleteRecord("ourbank_product",$id);
					//update
            $this->_redirect('/product');// 				}
// 			}
			
		}
	}
}
}
