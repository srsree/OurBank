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
class Asset_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle='Asset Details';
    }

    public function indexAction() {
        $asset=new Asset_Form_asset();
        $this->view->form=$asset;
	$assetmodel=new Asset_Model_asset();
	  $immovableassets=$assetmodel->getimmovableassets(); 
            $this->view->immovable=$immovableassets;
            foreach($this->view->immovable as $immovable)
            {
                $b2='icheck'.$immovable['asset_id'];
                    $imid=$immovable['asset_id'];
                    $this->view->form->addElement(new Zend_Form_Element_Checkbox($b2));
                    $this->view->form->$b2->setAttrib('onclick', 'immoveableasset("'.$imid.'")');
                    $this->view->form->$b2->setAttrib('class','txt_put');
                    $this->view->form->$b2->setRequired();

                    $a2='itext'.$immovable['asset_id'];
                    $this->view->form->addElement(new Zend_Form_Element_Text($a2));
                    $this->view->form->$a2->addValidators(array(array('Float'))); 
            }
    
            $nonlivingAssets = $assetmodel->getnonLivingassets();
            $this->view->nonlivingdetails=$nonlivingAssets;

             foreach($this->view->nonlivingdetails as $nonliving)  {
                    $b='ncheck'.$nonliving['asset_id'];
                    $nid=$nonliving['asset_id'];
                    $this->view->form->addElement(new Zend_Form_Element_Checkbox($b));
                    $this->view->form->$b->setAttrib('onclick', 'nonlivingassets("'.$nid.'")');
                    $this->view->form->$b->setAttrib('class','txt_put');
                     //$this->view->form->$b->setValue($nid);
                    $this->view->form->$b->setRequired();

                    $a='ntext'.$nonliving['asset_id'];
                    $this->view->form->addElement(new Zend_Form_Element_Text($a));
                    $this->view->form->$a->addValidators(array(array('Float')));
                }

            $LivingAssets = $assetmodel->getlivingassets();
            $this->view->living=$LivingAssets;

            foreach($this->view->living as $living)  {
                    $b1='lcheck'.$living['asset_id'];
                    $lid=$living['asset_id'];
                    $this->view->form->addElement(new Zend_Form_Element_Checkbox($b1));
                    $this->view->form->$b1->setAttrib('onclick', 'livingassets("'.$lid.'")');
                    $this->view->form->$b1->setAttrib('class','txt_put');
                    $this->view->form->$b1->setRequired();

                    $a1='ltext'.$living['asset_id'];
                    $this->view->form->addElement(new Zend_Form_Element_Text($a1));
                    $this->view->form->$a1->addValidators(array(array('Float')));
                }
    }



}
