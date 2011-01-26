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

class Membership_Form_Individualedit extends Zend_Form
{
    public function init() {
        Zend_Dojo::enableForm($this);
    }

    public function __construct($app) {
        Zend_Dojo::enableForm($this);
        parent::__construct($app);

        $membertitle = new Zend_Form_Element_Select('membertitle');
        $membertitle->setAttrib('class', 'txt_put');        
        $membertitle->setAttrib('id', 'membertitle');
        $membertitle->setAttrib('tabindex', '3');

        $memberfirstname = new Zend_Form_Element_Text('memberfirstname');
        $memberfirstname->setAttrib('class', '');
        $memberfirstname->setAttrib('size', '10');
        $memberfirstname->setAttrib('id', 'memberfirstname');
        $memberfirstname->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));

        $memberfirstname1 = new Zend_Form_Element_Text('memberfirstname1');
        $memberfirstname1->setAttrib('class', '');
        $memberfirstname1->setAttrib('id', 'memberfirstname1');
        $memberfirstname1->setAttrib('size', '10');
        $memberfirstname1->setAttrib('readonly', 'true');
//         $memberfirstname1->setAttrib('style','background-color:	#5CB3FF');

        $memberaddressline1 = new Zend_Form_Element_Text('memberaddressline1');
        $memberaddressline1->setAttrib('class', 'txt_put');
        $memberaddressline1->setAttrib('id', 'memberaddressline1');
        $memberaddressline1->setAttrib('tabindex', '13');  

        $membermiddlename = new Zend_Form_Element_Text('membermiddlename');
        $membermiddlename->setAttrib('class', 'txt_put');
        $membermiddlename->setAttrib('id', 'membermiddlename');
        $membermiddlename->setAttrib('tabindex', '5');

        $memberaddressline2 = new Zend_Form_Element_Text('memberaddressline2');
        $memberaddressline2->setAttrib('class', 'txt_put');
        $memberaddressline2->setAttrib('id', 'memberaddressline2');
        $memberaddressline2->setAttrib('tabindex', '14');

        $memberlastname = new Zend_Form_Element_Text('memberlastname');
        $memberlastname->setAttrib('class', 'txt_put');
        $memberlastname->setAttrib('id', 'closedate');
        $memberlastname->setAttrib('tabindex', '6');

        $MFI_member  = new Zend_Form_Element_Select('MFI_member');
//         $MFI_member->addMultiOption('','Select');
        $MFI_member->setAttrib('class', 'txt_put');
        $MFI_member->setAttrib('id', 'MFI_member');

        $memberaddressline3  = new Zend_Form_Element_Text('memberaddressline3');
        $memberaddressline3->setAttrib('class', 'txt_put');
        $memberaddressline3->setAttrib('id', 'memberaddressline3');
        $memberaddressline3->setAttrib('tabindex', '15');

        $memberpersonalid  = new Zend_Form_Element_Text('memberpersonalid ');
        $memberpersonalid->setAttrib('class', 'txt_put');
        $memberpersonalid->setAttrib('id', 'memberpersonalid');
        $memberpersonalid->setAttrib('tabindex', '7');

        $memberdateofbirth = new Zend_Form_Element_Text('memberdateofbirth ');
 	$memberdateofbirth->setAttrib('tabindex', '8');
        $memberdateofbirth->setAttrib('class', 'txt_put');
	$memberdateofbirth->setAttrib('size', '10');
        $memberdateofbirth->setAttrib('id', 'memberdateofbirth');
        $memberdateofbirth->setRequired(true)
	->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
	array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));



        $membercity = new Zend_Form_Element_Text('membercity');
        $membercity->setAttrib('class', 'txt_put');
        $membercity->setAttrib('id', 'membercity');
        $membercity->setAttrib('tabindex', '16');



        $gender_id  = new Zend_Form_Element_Select('gender_id');
        $gender_id->addMultiOption('','Select');
        $gender_id->setAttrib('class', 'txt_put');
        $gender_id->setAttrib('id', 'gender_id');
        $gender_id->setAttrib('tabindex', '9');       

        $memberstate = new Zend_Form_Element_Text('memberstate');
        $memberstate->setAttrib('class', 'txt_put');
        $memberstate->setAttrib('id', 'memberstate'); 
        $memberstate->setAttrib('tabindex', '17');

        $membercountry = new Zend_Form_Element_Text('membercountry');
        $membercountry->setAttrib('class', 'txt_put');
        $membercountry->setAttrib('id', 'membercountry');
        $membercountry->setAttrib('tabindex', '18');

        $memberpincode = new Zend_Form_Element_Text('memberpincode');
        $memberpincode->setAttrib('class', 'txt_put');
        $memberpincode->setAttrib('id', 'memberpincode');
        $memberpincode->setAttrib('tabindex', '19');

        $memberphone = new Zend_Form_Element_Text('memberphone');
        $memberphone->setAttrib('class', 'txt_put');
        $memberphone->setAttrib('id', 'memberphone');
        $memberphone->setAttrib('tabindex', '20');

        $memberchildrennumber = new Zend_Form_Element_Text('memberchildrennumber');
        $memberchildrennumber->setAttrib('class', 'txt_put');
        $memberchildrennumber->setAttrib('id', 'memberchildrennumber');

        $memberprofession = new Zend_Form_Element_Text('memberprofession');
        $memberprofession->setAttrib('class', 'txt_put');
        $memberprofession->setAttrib('id', 'memberprofession');

        $membereducation = new Zend_Form_Element_Text('membereducation');
        $membereducation->setAttrib('class', 'txt_put');
        $membereducation->setAttrib('id', 'membereducation');

//         $photo = new Zend_Form_Element_File('photo');
//         $photo->setAttrib('size', '11');
//         $photo->setLabel('Upload an image:');
//         $photo->setAttrib('tabindex', '12');  

        $membereconomicalstatusdescription = new Zend_Form_Element_Select('membereconomicalstatusdescription');
        $membereconomicalstatusdescription->addMultiOption('','Select');
        $membereconomicalstatusdescription->setAttrib('class', 'txt_put');
        $membereconomicalstatusdescription->setAttrib('id', 'membereconomicalstatusdescription');

        $relationship = new Zend_Form_Element_Select('relationship');
        $relationship->setAttrib('class', 'txt_put');
        $relationship->setAttrib('id', 'relationship');

        $physicalstatus_id = new Zend_Form_Element_Select('physicalstatus_id');
        $physicalstatus_id->addMultiOption('','Select');
        $physicalstatus_id->setAttrib('class', 'txt_put');
        $physicalstatus_id->setAttrib('id', 'physicalstatus_id');
        $physicalstatus_id->setAttrib('tabindex', '11');  

        $membermaritalstatus_id = new Zend_Form_Element_Select('membermaritalstatus_id');
        $membermaritalstatus_id->addMultiOption('','Select');
        $membermaritalstatus_id->setAttrib('class', 'txt_put');
        $membermaritalstatus_id->setAttrib('id', 'membermaritalstatus_id');
        $membermaritalstatus_id->setAttrib('tabindex', '10');  

        $memberStatus = new Zend_Form_Element_Radio('memberstatus_id');
        //$memberStatus->setAttrib('checked', 'true');
        $memberStatus->setAttrib('id', 'memberstatus_id');

        $memberId = new Zend_Form_Element_Text('member_id');
        $memberId->setAttrib('class', 'txt_put');
        $memberId->setAttrib('readonly', 'true');
        $memberId->setAttrib('size', '10');

        $memberhouse = new Zend_Form_Element_Checkbox('memberhouse');
        $memberhouse->setAttrib('id', 'memberhouse ');
        $memberhouse->setAttrib('class', 'txt_put');
        $memberhouse->setAttrib('onchange','toggleStatus();');

        $memberhouse = new Zend_Form_Element_Checkbox('memberhouse');
        $memberhouse->setAttrib('class', 'txt_put');
        $memberhouse->setAttrib('id', 'memberhouse');
        $memberhouse->setAttrib('onchange','togglehouse();');

        $memberland = new Zend_Form_Element_Checkbox('memberland');
        $memberland->setAttrib('class', 'txt_put');
        $memberland->setAttrib('id', 'memberland');
        $memberland->setAttrib('onchange','toggleland();');

        $homeSize = new Zend_Form_Element_Text('memberhomesize');
        $homeSize->setAttrib('class', 'txt_put');
        $homeSize->setAttrib('id', 'memberhomesize');
        $homeSize->setAttrib('size', '8');
        $homeSize->setAttrib('disabled', 'true');

        $landSize = new Zend_Form_Element_Text('memberlandsize');
        $landSize->setAttrib('class', 'txt_put');
        $landSize->setAttrib('id', 'memberlandsize');
        $landSize->setAttrib('size', '8');
        $landSize->setAttrib('disabled', 'true');
	
	$numlandSize = new Zend_Form_Element_Text('numlandSize');
        $numlandSize->setAttrib('class', 'txt_put');
        $numlandSize->setAttrib('id', 'numlandSize');
        $numlandSize->setAttrib('size', '8');
        
        $otherlivingassets  = new Zend_Form_Element_Select('otherlivingassets');
        $otherlivingassets->setAttrib('class', 'txt_put');
        $otherlivingassets->setAttrib('id', 'otherlivingassets');
        $otherlivingassets->addMultiOption('','Select');
	$otherlivingassets->setAttrib('onchange', 'livingassets();');

	$othernonlivingassets  = new Zend_Form_Element_Select('othernonlivingassets');
        $othernonlivingassets->setAttrib('class', 'txt_put');
        $othernonlivingassets->setAttrib('id', 'othernonlivingassets');
        $othernonlivingassets->addMultiOption('','Select');
	$othernonlivingassets->setAttrib('onchange', 'nonlivingassets();');	

	$numotherassets = new Zend_Form_Element_Text('numotherassets');
        $numotherassets->setAttrib('class', 'txt_put');
        $numotherassets->setAttrib('id', 'numotherassets');
        $numotherassets->setAttrib('size', '8');
       
        $OFFICE_TYPE = new Zend_Form_Element_Select('officeType');
        $OFFICE_TYPE->addMultiOption('','Select');
        $OFFICE_TYPE->setAttrib('class','txt_put');
        $OFFICE_TYPE->setAttrib('onchange', 'getBranch(this.value,"'.$app.'")');
        $OFFICE_TYPE->setAttrib('tabindex', '1');

        $SUB_OFFICE = new Zend_Form_Element_Select('subOffice');
        $SUB_OFFICE->addMultiOption('','Select...');
        $SUB_OFFICE->setAttrib('class','txt_put');
        $SUB_OFFICE->setAttrib('tabindex', '2');

        $transporation_for_schoolstatus = new Zend_Form_Element_Select('transporation_for_schoolstatus');
        $transporation_for_schoolstatus->addMultiOption('','Select');
        $transporation_for_schoolstatus->setAttrib('class', 'txt_put');
        $transporation_for_schoolstatus->setAttrib('id', 'transporation_for_schoolstatus');

        $transporation_for_schoolstatus = new Zend_Form_Element_Select('transporation_for_schoolstatus');
        $transporation_for_schoolstatus->addMultiOption('','Select');
        $transporation_for_schoolstatus->setAttrib('class', 'txt_put');
        $transporation_for_schoolstatus->setAttrib('id', 'transporation_for_schoolstatus');

        $school_locationstatus = new Zend_Form_Element_Select('school_locationstatus');
        $school_locationstatus->addMultiOption('','Select...');
        $school_locationstatus->setAttrib('class', 'txt_put');
        $school_locationstatus->setAttrib('id', 'school_locationstatus');

        $qualificationdetails = new Zend_Form_Element_Select('qualificationdetails');
        $qualificationdetails->addMultiOption('','Select...');
        $qualificationdetails->setAttrib('class', 'txt_put');
        $qualificationdetails->setAttrib('id', 'qualificationdetails');

        $profession = new Zend_Form_Element_Select('profession');
        $profession->addMultiOption('','Select');
        $profession->setAttrib('class', 'txt_put');
        $profession->setAttrib('id', 'profession');

        $health_problem = new Zend_Form_Element_Select('health_problem');
        $health_problem->addMultiOption('','Select');
        $health_problem->setAttrib('class', 'txt_put');
        $health_problem->setAttrib('id', 'health_problem');

        $earningsstatus = new Zend_Form_Element_Select('earningsstatus');
        $earningsstatus->addMultiOption('','Select');
        $earningsstatus->setAttrib('class', 'txt_put');
        $earningsstatus->setAttrib('id', 'earningsstatus');

        $submit = new Zend_Form_Element_Submit('Save');
        $submit->setAttrib('id', 'save');

        $this->addElements( array ($OFFICE_TYPE,
                                $SUB_OFFICE,
                                $memberfirstname,
                                $memberfirstname1,
                                $membertitle,
                                $memberaddressline1,
                                $membermiddlename,
                                $memberaddressline2,
                                $memberlastname,
                                $gender_id,
                                $memberaddressline3,
                                $memberpersonalid,
                                $membercity,
                                $memberdateofbirth,
                                $memberstate,
                                $membercountry,
                                $MFI_member,
                                $membermaritalstatus_id,
                                $membereconomicalstatusdescription,
                                $memberpincode,
                                $memberchildrennumber,
                                $memberphone,
                               // $photo,
                                $memberhouse,
                                $memberland,
                                $otherlivingassets,
				$othernonlivingassets,
                                $physicalstatus_id,
                                $relationship,
                                $memberStatus,
                                $homeSize,
                              	$landSize,
                                $memberId,
                                $transporation_for_schoolstatus,
                                $school_locationstatus,
                                $qualificationdetails,
                                $profession,
                                $health_problem,
                                $earningsstatus,
				$numlandSize,
				$numotherassets));

        $memberId = new Zend_Form_Element_Hidden('memberId');
        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'officesubmit');
        $this->addElements(array($submit,$memberId));
    }
}

