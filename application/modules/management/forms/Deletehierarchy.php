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
class Management_Form_Deletehierarchy extends Zend_Form{
    public function memberForm($elements) {
    parent::__construct($elements);
        $this->setName('Search');
        $ZendTranslate=Zend_Registry::get('Zend_Translate');
        foreach ($elements as $ele) {
        foreach ($ele as $key=>$val) {
        if($ele['type']=='Text') {
           $grantname = new Zend_Form_Element_Text($ele['name']);
           $grantname->setAttrib('class', 'txt_put');
        } else if($ele['type']=='Select') {
                  $grantname = new Zend_Form_Element_Select($ele['name']);
                  $grantname->setAttrib('class','selectbutton');
                  $grantname->addMultiOption('',$ZendTranslate->_('select').'...');
          } else if($ele['type']=='Hidden') {
                    $grantname = new Zend_Form_Element_Hidden($ele['name']);
            }else if($ele['type']=='Submit') {
                     $grantname = new Zend_Form_Element_Submit($ele['name']);
                    if($ele['name']=='Search') {
                       $grantname->setAttrib('class', 'primaryAction');
                       $grantname->setAttrib('id', 'submit-wf_TestForm');
                     } else {
                         $grantname->setAttrib('class', 'officesubmit');
}
        }
        if($ele['Required']=='true') {
           $grantname->setRequired(true);
        }
        $this->addElements(array($grantname));
        }
        }
            return $this;
    }

    public function searchBlock($elements,$form1)
    {
		$ZendTranslate=Zend_Registry::get('Zend_Translate');
		$output[]='<div id="searchDiv">
						<fieldset>
							<legend>'.$ZendTranslate->_('search').'</legend>
							<div class="search">
							<table width="100%">
							<form action="index" method="POST">';
		for($i=0;$i<count($elements)-1;$i++) {
			if($elements[$i]['type']=='Text' || $elements[$i]['type']=='Select') {
				$output[]="<tr>";
				$output[]="<td class='label'>".$elements[$i]['Label'].":</td><td>".$form1->$elements[$i]['name']."</td>";
					if($i<count($elements)-1 && ($elements[$i+1]['type']=='Text' || $elements[$i+1]['type']=='Select')) {
						$output[]="<td class='label'>".$elements[$i+1]['Label'].":</td><td>".$form1->$elements[$i+1]['name']."</td>";
					}
				$output[]="</tr>";
				$i++;
			}
		}
		$output[]="<tr>
					<td colspan='4' align='center'>".$form1->Search."</Td>
				</tr>";
		$output[]='	</form>
   					</table>
					</div>
 					</fieldset> 
					</div>';
	return $output;
	}

    public function deleteForm($id)
    {
		parent::__construct($id);
        $this->setName('deletealbum');
        $submit_yes = new Zend_Form_Element_Submit('Yes');
        $submit_yes->setAttrib('id', 'Yes');
        $submit_no = new Zend_Form_Element_Submit('No');
		$submit_no->setAttrib('id', 'No'); 
        $id = new Zend_Form_Element_Hidden($id);
        $this->addElements(array($submit_yes,$submit_no,$id));
		return $this;
	}

}	