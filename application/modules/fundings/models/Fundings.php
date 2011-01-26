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
class Fundings_Model_Fundings extends Zend_Db_Table 
{
    protected $_name = 'ob_funding';


    public function SearchFundings($post) 
	{

		$select = $this->select()
				->setIntegrityCheck(false)  
				->join(array('a' => 'ob_funding'),array('funding_id'))
				->join(array('c' => 'ob_funder'),'a.funder_id = c.id',array('c.id'))
				->join(array('d' => 'ob_institution'),'a.institution_id = d.id',array('d.id'))
				->join(array('e' => 'ob_currency'),'a.currency_id = e.id',array('e.id'))			
				->where('a.name like "%" ? "%"',$post['field2'])
				->where('a.amount like "%" ? "%"',$post['field4'])
				->where('a.beginingdate like "%" ? "%"',$post['field7'])
				->where('a.closingdate like "%" ? "%"',$post['field8']);
		return $this->fetchAll($select);
                //die($select->__toString($select));
	}
        
    public function viewfundings($id)
    {
	$select = $this->select()
		->setIntegrityCheck(false)  

		->join(array('b' => 'ob_funding'),array('b.id'))
        ->where('b.id = ?',$id)
		->join(array('c' => 'ob_funder'),'b.funder_id = c.id',array('c.name as fundername'))
		->join(array('d' => 'ob_institution'),'b.institution_id = d.id',array('d.name as institutionname'))
		->join(array('e' => 'ob_currency'),'b.currency_id = e.id',array('e.name as currency'))
		->join(array('f' => 'ourbank_glsubcode'),'f.id = b.glsubcode_id',array('f.header as glname'));

		//die($select->__toString($select));
		$result = $this->fetchAll($select);
		return $result->toArray();
	 
        
    }
    



    

}