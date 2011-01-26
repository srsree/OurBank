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
    
class Reports_Model_Par extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    

    public function getDue30() {

        $date = date("Y-m-d");// current date
        $enddate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -30 days"));

        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_installmentdetails'))
                        ->where('A.installment_status = 5')
                        ->where('A.accountinstallment_date >= "'.$enddate.'" AND A.accountinstallment_date <= "'.$date.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' );
//                         ->group('B.offerproductname');
                        //die($select->__toString());
        return $this->fetchAll($select);
        
    }

    public function getDueabove30less60() {

        $date = date("Y-m-d");// current date
        $fromDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -30 days"));
        $toDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -60 days"));
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_installmentdetails'))
                        ->where('A.installment_status = 5')
                        ->where('A.accountinstallment_date > "'.$toDate.'" AND A.accountinstallment_date <="'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' );
//                         ->group('B.offerproductname');
                    //   die($select->__toString());
        return $this->fetchAll($select);
        
    }

    public function getDueabove60less90() {

        $date = date("Y-m-d");// current date
        $fromDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -60 days"));
        $toDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -90 days"));
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_installmentdetails'),array('SUM(accountinstallment_amount) as sum'))
                        ->where('A.installment_status = 5')
                        ->where('A.accountinstallment_date > "'.$toDate.'" AND A.accountinstallment_date <="'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->group('C.account_id');
                    //  die($select->__toString());
        return $this->fetchAll($select);
        
    }
    public function getDueabove90less180() {

        $date = date("Y-m-d");// current date
        $fromDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -90 days"));
        $toDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -180 days"));
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_installmentdetails'),array('SUM(accountinstallment_amount) as sum'))
                        ->where('A.installment_status = 5')
                        ->where('A.accountinstallment_date > "'.$toDate.'" AND A.accountinstallment_date <="'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->group('C.account_id');
                    //  die($select->__toString());
        return $this->fetchAll($select);
        
    }
    public function getDueabove180less360() {

        $date = date("Y-m-d");// current date
        $fromDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -180 days"));
        $toDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -360 days"));
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_installmentdetails'),array('SUM(accountinstallment_amount) as sum'))
                        ->where('A.installment_status = 5')
                        ->where('A.accountinstallment_date > "'.$toDate.'" AND A.accountinstallment_date <="'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->group('C.account_id');
                    //  die($select->__toString());
        return $this->fetchAll($select);
        
    }

    public function getDueabove360() {

        $date = date("Y-m-d");// current date
        $toDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " -360 days"));
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_installmentdetails'),array('SUM(accountinstallment_amount) as sum'))
                        ->where('A.installment_status = 5')
                        ->where('A.accountinstallment_date < "'.$toDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->group('C.account_id');
                    //  die($select->__toString());
        return $this->fetchAll($select);
        
    }




}
