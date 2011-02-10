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
 *  create an office hierarchy controller for add, view search filtered values
 */
class Officehierarchy_IndexController extends Zend_Controller_Action{

    public function init() {
         $this->view->pageTitle=$this->view->translate('Office Hierarchy');
	//session 
         $sessionName = new Zend_Session_Namespace('ourbank');
         $this->view->createdby = $sessionName->primaryuserid;
    }

	//view office hierarchy
    public function indexAction() {
        $this->view->title = $this->view->translate('OfficeHierarchy');
	//instance of office hierarchy
        $officehierarchy = new Officehierarchy_Model_Officehierarchy();
        $noOfficeLevel= $officehierarchy->noOfficelevel();
        $this->view->noOfficeLevel=$noOfficeLevel;

        if($noOfficeLevel == 0) {
           $cat= $this->_request->getParam('officeNo'); /**No of levels inserting*/
           $this->view->cat=$cat;
	   //this create form to display non existed Office hierarchy
           $form1 = new Officehierarchy_Form_Hierarchy1($noOfficeLevel,$cat);
           $this->view->form1 = $form1;
           $this->view->form1->officeNo->setAttrib('onchange', 'reload(this.value)');
           $this->view->form1->Edit->setName('Confirm');
           $this->view->form1->Edit->setLabel('confirm');
	   //set office numbers for office levels in view page
           if($cat) { 
              $this->view->form1->officeNo->setValue($cat,$cat);
            }
		//get and check poster values
            if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                $formData = $this->_request->getPost();
                $officeNo= $form1->getValue('officeNo');
                if ($form1->isValid($formData)) {
                    for($i=1;$i<=$officeNo;$i++) {

                        $officeType=ucwords($form1->getValue('officeType'.$i));
                        $officeCode=ucwords($form1->getValue('officeCode'.$i));

                        $date=date("Y-m-d");
                        $createdby = $this->view->createdby;
                        $data = array('id'=>'',
                                      'type' => $officeType,
                                      'short_name'=>$officeCode,
                                      'Hierarchy_level'=>$i,
                                      'created_userid'=>$createdby,
                                      'createddate' =>$date);
                        $officehierarchy->officeInsert($data);
                    }
                    $this->_redirect('officehierarchy/index');
               }
            }
            } else {
                 $this->view->errorExisted = $this->_request->getParam('Existed');
                 $officehierarchy = new Officehierarchy_Model_Officehierarchy();
                 $eacharraysent1=$this->view->officeHierarchySelect = $officehierarchy->fetchAllHierarchy();
	   	//this create form to display existed Office hierarchy
                $form1 = new Officehierarchy_Form_Hierarchy($noOfficeLevel,$noOfficeLevel);
                $this->view->form1 = $form1;
                $this->view->form1->officeNo->setValue($noOfficeLevel);
                $this->view->noOfficeLevel=$noOfficeLevel;
                $i=1; 
		//fetch office details and set the values
                foreach($eacharraysent1 as $eacharraysent) {
                    $a='officeType'.$i;
                    $b='officeCode'.$i;
                    $c='id'.$i;
                    $d='hierarchyLevel'.$i;
                    $e='disable'.$i;
                    $this->view->form1->$a->setValue($eacharraysent->type);
                    $this->view->form1->$a->setAttrib('readonly','true');
                    $this->view->form1->$b->setAttrib('size', '2');
                    $this->view->form1->$b->setAttrib('readonly','true');
                    $this->view->form1->$b->setValue($eacharraysent->short_name);
                    $this->view->form1->$c->setValue($eacharraysent->id);
                    $this->view->form1->$d->setValue($eacharraysent->Hierarchy_level);

                    $this->view->officeExistedInThisType = $officehierarchy->officeExistedInThisType($eacharraysent->id);
			//count and set if it is used to disabled
                    if(count($this->view->officeExistedInThisType) > 0) {
                                $this->view->$e='disabled';
                    } else {
                        $this->view->$e='';
                        }
                    $i++;
                    }
                }
		//delete office hierarchy wise
                if($this->_request->getParam('delete')) {
                   $officeTypeId = $this->_request->getParam('officeTypeId');
                   $officehierarchy = new Officehierarchy_Model_Officehierarchy();
                   $this->view->officeExistedInThisType = $officehierarchy->officeExistedInThisType($officeTypeId);
                   if(count($this->view->officeExistedInThisType)>0) {
		//set pop up and redirect
                        echo "<script language=javascript>alert('you cant delete the office .First delete lower office(".$officeName.")')</script>";
                        echo "<script>window.location='".$this->view->appPath."office/public'</script>";
                    } else {
                        $this->_redirect('officehierarchy/delete/id/'.$officeTypeId);
                    }
                }
    }

	//edit office hierarchy
   function editAction() {
        $this->view->title = $this->view->translate('Edit OfficeHierarchy');
        $officehierarchy = new Officehierarchy_Model_Officehierarchy();
        $this->view->officeHierarchySelect = $officehierarchy->fetchAllHierarchy();
	//get posted office id
        $noOfficeLevel=$this->_request->getPost('officeNo');

	//form instance for edit
        $form1 = new Officehierarchy_Form_Hierarchy1($noOfficeLevel,$noOfficeLevel);
        $this->view->form1 = $form1;
        $this->view->form1->officeNo->setValue($noOfficeLevel);
        $this->view->Edit=$this->_request->getPost('Next');
	//get confirmation
        $this->view->Confirm=$this->_request->getPost('Confirm');
        $this->view->noOfficeLevel=$noOfficeLevel;

        if($this->_request->getPost('Next')) {
            $highlevel=$officehierarchy->findhighlevel();
           $officeLevel=$this->_request->getPost('officeLevel');

         foreach($highlevel as $highlevel1) { $high=$highlevel1->high;}

// if($high!=$highlevel){


           $this->view->officeLevel=$officeLevel;
           $formData = $this->_request->getPost();
           $this->view->form1->officeLevel->setValue($officeLevel);
           for($i=1;$i<=$noOfficeLevel;$i++) {
               $a='officeType'.$i;
               $b='officeCode'.$i;
               $c='id'.$i;
               $d='hierarchyLevel'.$i;
                if($i <= $officeLevel) {
                   $this->view->form1->$a->setValue($this->_request->getPost('officeType'.$i));
                   $this->view->form1->$b->setAttrib('size', '2');
                   $this->view->form1->$a->setAttrib('readonly', 'true');
                   $this->view->form1->$b->setAttrib('readonly', 'true');
                   $this->view->form1->$a->setAttrib('class', 'txt_put nonEditing');

                    $this->view->form1->$b->setAttrib('class', 'txt_put nonEditing');
                    $this->view->form1->$b->setValue($this->_request->getPost('officeCode'.$i));
                    $this->view->form1->$d->setValue($this->_request->getPost('hierarchyLevel'.$i));
                    $this->view->form1->$c->setValue($this->_request->getPost('id'.$i));
                } else {
                    if($i == $officeLevel+1) {
                       $validator = new Zend_Validate_Db_NoRecordExists('ourbank_officehierarchy','type');		
                       $validator1 = new Zend_Validate_Db_NoRecordExists('ourbank_officehierarchy','short_name');
                       $officeType=$this->_request->getPost('officeType'.$noOfficeLevel);
                       $officeCode=$this->_request->getPost('officeCode'.$noOfficeLevel);
                       if ($validator->isValid($officeType)){
                            if ($validator1->isValid($officeCode)){
                                $this->view->form1->$a->setValue($this->_request->getPost('officeType'.$noOfficeLevel));
                                $this->view->form1->$b->setAttrib('size', '2');
                                $this->view->form1->$a->setAttrib('readonly', 'true');
                                $this->view->form1->$b->setAttrib('readonly', 'true');
                                $this->view->form1->$a->setAttrib('class', 'txt_put editing');

                                $this->view->form1->$b->setAttrib('class', 'txt_put editing');
                                $this->view->form1->$b->setValue($this->_request->getPost('officeCode'.$noOfficeLevel));
                                $this->view->form1->$c->setValue($this->_request->getPost('id'.$noOfficeLevel));
                                $this->view->form1->$d->setValue($officeLevel+1);
                            } else {
                                    $messages = $officeCode.'alreadyexisting';
                                    $this->_redirect("officehierarchy?Existed=".$messages);
                                }
                        } else {
                            $messages = $officeType.'alreadyexisting';
                            $this->_redirect("officehierarchy?Existed=".$messages);
                          }
                    } else {
                        $officeLevel++;
                        $this->view->form1->$a->setValue($this->_request->getPost('officeType'.$officeLevel));
                        $this->view->form1->$b->setAttrib('size', '2');
                        $this->view->form1->$a->setAttrib('readonly', 'true');
                        $this->view->form1->$b->setAttrib('readonly', 'true');
                        $this->view->form1->$a->setAttrib('class', 'txt_put nonEditing');

                        $this->view->form1->$b->setAttrib('class', 'txt_put nonEditing');
                        $this->view->form1->$b->setValue($this->_request->getPost('officeCode'.$officeLevel));
                        $this->view->form1->$c->setValue($this->_request->getPost('id'.$officeLevel));
                        $this->view->form1->$d->setValue($officeLevel+1);
                    }
                }
            }
                $this->view->form1->Edit->setName('Confirm');
                $this->view->form1->Edit->setLabel('confirm');
                $this->view->form1->Edit->setAttrib('class', 'officesubmit');
		//set validation 
                $this->view->form1->officeLevel->setRequired(true)
                     ->addValidators(array(array('NotEmpty'),array('stringLength', false, array(1, 2)),array('Digits') ));
        }


	//get confirmation and update
            if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                $formData = $this->_request->getPost();
                $officeLevel=$this->_request->getPost('officeLevel');
                if ($form1->isValid($formData)) {
                if($officeLevel) {
		    //increment of office id, code, and office type
                    for($i=1;$i<=$this->_request->getPost('officeNo');$i++) {
                        if($i <= $officeLevel) {
                           $officeType=ucwords($form1->getValue('officeType'.$i));
                           $id=$form1->getValue('id'.$i);
                           $officeCode=ucwords($form1->getValue('officeCode'.$i));
                           $level=$form1->getValue('hierarchyLevel'.$i);
                           $data = array('type' => $officeType,
                                         'Hierarchy_level'=>$level,
                                         'short_name' =>$officeCode);
                           $officehierarchy->officeUpdate($id,$data);
                    } else {
                            if($i == $officeLevel+1) {	
                               $officeType=ucwords($form1->getValue('officeType'.$i));
                               $officeCode=ucwords($form1->getValue('officeCode'.$i));
                               $level=$form1->getValue('hierarchyLevel'.$i);
                               $createdby = $this->view->createdby;
                               $data = array('id'=>'',
                                             'type' => $officeType,
                                             'Hierarchy_level'=>$level,
                                             'created_userid'=>$createdby,
                                             'createddate'=>date("Y-m-d"),
                                             'short_name' =>$officeCode);
                                $date=date("Y-m-d");
                                $officehierarchy->officeInsert($data);
                            } else {	
                                $officeType=ucwords($form1->getValue('officeType'.$i));
                                $id=$form1->getValue('id'.$i);
                                $officeCode=ucwords($form1->getValue('officeCode'.$i));
                                $level=$form1->getValue('hierarchyLevel'.$i);
                                $date=date("Y-m-d");
                                $data = array('type' => $officeType,
                                              'Hierarchy_level'=>$level,
                                              'short_name' =>$officeCode);
                                $officehierarchy->officeUpdate($id,$data);
                            }
                        }
                    }
                }
                $this->_redirect('officehierarchy');
            }
            }

	//validate update confirmation
        if ($this->_request->isPost() && $this->_request->getPost('update')) {
	//edit form instance of office hierarchy
            $form1 = new Officehierarchy_Form_EditHierarchy();
            $this->view->form1 = $form1;
            $formData = $this->_request->getPost();
            if ($form1->isValid($formData)) {
                $validator = new Zend_Validate_Db_NoRecordExists('ourbank_officehierarchy','type');		
                $validator1 = new Zend_Validate_Db_NoRecordExists('ourbank_officehierarchy','short_name');	
                $id=$form1->getValue('id');
                $officeType=ucwords($form1->getValue('officeType'));
                $officeCode=ucwords($form1->getValue('officeCode'));
		//get new form data
                $data = array('type' => $officeType,
                              'short_name' =>$officeCode);
                                $officehierarchy = new Officehierarchy_Model_Officehierarchy();
                                $result=$officehierarchy->fetchOneOfficeHierarchy($id);
				//fetch existing data
                                foreach($result as $hierarchyArray) {
                                    $oldData = array('type' => $hierarchyArray->officetype,
                                                     'short_name' =>$hierarchyArray->officeshort_name);
                                }
				//compare entered and existing data
                                $match = array();
                                foreach ($oldData as $key=>$val) {
                                if ($val != $data[$key]) {
                                    $match[] = $key;
                                }
                                }
				//count no.of existing data matching
                                if(count($match) <= 0) {
                                $this->view->updatEerror='updatemessage';
                                $this->view->form1->Edit->setName('update');
                                $this->view->form1->Edit->setLabel('update');
                                $this->view->form1->Edit->setAttrib('class', 'officesubmit');
                                $this->_redirect("officehierarchy");
                                } else  if ($validator->isValid($officeType) || $validator1->isValid($officeCode)){
                                       $officehierarchy = new Officehierarchy_Model_Officehierarchy();
                                       $editOfficeHierarchy=$officehierarchy->editOfficeHierarchy($id);
                                       foreach($editOfficeHierarchy as $editOfficeHierarchyArray) {
                                       if ($editOfficeHierarchyArray->officetype!=$officeType || $editOfficeHierarchyArray->officeshort_name!=$officeCode) {
                                               $officehierarchy->officeUpdate($id,$data);
                                               $this->_redirect('officehierarchy');
                                      } else {
                                          $this->view->form1->Edit->setName('update');
                                          $this->view->form1->Edit->setLabel($this->view->ZendTranslate->_("update"));
                                          $this->view->form1->Edit->setAttrib('class', 'officesubmit');
                                          $messages = $officeType.' (OR) '.$officeCode.' '.'alreadyexisting';
                                          $this->_redirect("officehierarchy?Existed=".$messages);
                                        }
                                     }
                        } else {
                            $this->view->form1->Edit->setName('update');
                            $this->view->form1->Edit->setLabel('update');
                            $this->view->form1->Edit->setAttrib('class', 'officesubmit');
			    //existing message
                            $messages = $officeType.' (OR) '.$officeCode.'alreadyexisting';
                            $this->_redirect("officehierarchy?Existed=".$messages);
                        }
                    } else {
                        $messages= 'noProperData';
                        $this->_redirect("officehierarchy?Existed=".$messages);
                    }
                 }
            }

	//inline edit in every seperate field
    function inlineeditAction() {
	//set to disable layout
        $this->_helper->layout->disableLayout();
        $id = $this->_request->getParam('subOfficeId');

        $form1 = new Officehierarchy_Form_EditHierarchy();
        $this->view->form1 = $form1;

        $officehierarchy = new Officehierarchy_Model_Officehierarchy();
        $this->view->result1=$result=$officehierarchy->fetchOneOfficeHierarchy($id);
        foreach($result as $hierarchyArray) {
                $officetype =$hierarchyArray->type;
                $officeshort_name=$hierarchyArray->short_name;
                $this->view->hierarchyLevel=$hierarchyArray->Hierarchy_level;
        }
	//view instance of update form attributes
        $this->view->form1->officeType->setValue($officetype);
        $this->view->form1->officeType->setAttrib('class', 'txt_put editing');

        $this->view->form1->officeCode->setAttrib('class', 'txt_put editing');
        $this->view->form1->officeCode->setAttrib('size', '2');
        $this->view->form1->officeCode->setValue($officeshort_name);
        $this->view->form1->hierarchyLevel->setValue($this->view->hierarchyLevel);
        $this->view->form1->id->setValue($id);
        $this->view->form1->Edit->setName('update');
        $this->view->form1->Edit->setLabel('update');
        $this->view->form1->Edit->setAttrib('class', 'officesubmit');
        $this->view->form1->Edit->setAttrib('style', 'float: left;margin-left:2px');

	}
	
	//delete action
    function deleteAction() {
        $Management = new Officehierarchy_Form_Deletehierarchy;
        $this->view->deleteform = $Management->deleteForm('officeTypeId');
        $this->view->deleteid=$id = $this->_request->getParam('officeTypeId');
        $this->view->deleteform->officeTypeId->setValue($id);
        if($id) {
           $officehierarchy = new Officehierarchy_Model_Officehierarchy();
           $officeNames=$officehierarchy->fetchOneOfficeHierarchy($id);
         //   $this->view->officeTypeName=$officeNames[0]['officetype'];
           foreach($officeNames as $officeNames1) {
                   $this->view->officeTypeName=$officeNames1->type;
           }
        }
        if ($this->_request->isPost()) {
	   // gert confirmation action
            $action_yes = $this->_request->getPost('Yes');
            $action_no = $this->_request->getPost('No');
		//if yes updated
            if($action_yes=="Yes"){
               echo $officeTypeId=$this->_request->getParam('officeTypeId');
               $officehierarchy = new Officehierarchy_Model_Officehierarchy();
              $officeNames=$officehierarchy->fetchOneOfficeHierarchy($officeTypeId);
               foreach($officeNames as $officeNames1) {
                       $Hierarchy_level=$officeNames1->Hierarchy_level;
                }
                $officehierarchy = new Officehierarchy_Model_Officehierarchy();
                $officeLevelNames=$officehierarchy->officeLowerLevel($Hierarchy_level);
                foreach($officeLevelNames as $officeNames1) {
                        $input=array('Hierarchy_level'=>$officeNames1->Hierarchy_level-1);
                        $officehierarchy->officeTypeLevelUpdate($officeNames1->officetype_id,$input);
                }
                $officehierarchy->officeTypeDelete($officeTypeId);
                $this->_redirect('/officehierarchy');
		//if no redirect to index
            } else if($action_no=="No"){
                  $this->_redirect('/officehierarchy');	
               }
        }
     }
}
