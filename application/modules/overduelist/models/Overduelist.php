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
		class Overduelist_Model_Overduelist extends Zend_Db_Table { 
 			protected $_name = 'ob_accounts';

 
public function getbankNames() 
		{
         		$select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_institute_bank_details')
						->where('recordstatus_id=3');
        		return $result = $this->fetchAll($select);
      // die ($select->__toString($select));
    		}
 public function search($bank,$date,$officer)
		{
        		
  						$select=$this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a'=>'ourbank_installmentdetails'),array('count(a.	installment_id) as 				totalinstallments','Sum(a.installment_amount) as overdue','a.installment_date'))
                        ->where('a.installment_date <= "'.$date.'"')
                        ->where('a.installment_status=5')
						->where('a.created_by like "%" ? "%"',$officer)
						->group('a.account_id')
 						->join(array('b'=>'ourbank_loanaccounts'),'b.account_id=a.account_id',array('id'))
 						->join(array('c'=>'ourbank_accounts'),'c.id=b.account_id',array('c.account_number'))
                        ->where('c.status_id = 3 || c.status_id = 1')
 						->join(array('f'=>'ourbank_member'),'f.id=c.member_id',array('id'))
						->join(array('e'=>'ourbank_office'),'e.id=f.office_id',array('id'))
                        ->where('e.id like "%" ? "%"',$bank);



                                        //	die($select->__toString($select));

                        $result = $this->fetchAll($select);
                        return $result->toArray();
    		}


}