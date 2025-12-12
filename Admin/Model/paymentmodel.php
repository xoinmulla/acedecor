<?php
class Payment  implements JsonSerializable
{
    private $customer_name;
    private $customer_id;
    private $customer_contactnumber;
    private $total_amount;
    private $paid_amount;
    private $pending_amount;
    private $payment_mode;
    private $payment_description;
    private $payment_id;
    private $payment_plan;
    private $due_date;
    private $cheque_img;
    private $RTGS_no;
    private $payment_receipt;
    private $modified_by;
    private $table_name = "paymentinfo";

    function set_custid($custid)
    {
        $this->customer_id= $custid;
    }
    function get_custid()
    {
        return $this->customer_id;
    }

    function set_custname($custname)
    {
        $this->customer_name= $custname;
    }
    function get_custname()
    {
        return $this->customer_name;
    }

    function set_custcontactnumber($custcontactnumber)
    {
        $this->customer_contactnumber= $custcontactnumber;
    }
    function get_custcontactnumber()
    {
        return $this->customer_contactnumber;
    }

    function set_totalamt($totalamt)
    {
        $this->total_amount= $totalamt;
    }
    function get_totalamt()
    {
        return $this->total_amount;
    }

    function set_paidamt($paidamt)
    {
        $this->paid_amount= $paidamt;
    }
    function get_paidamt()
    {
        return $this->paid_amount;
    }

    function set_pendingamt($pendingamt)
    {
        $this->pending_amount= $pendingamt;
    }
    function get_pendingamt()
    {
        return $this->pending_amount;
    }

    function set_paymentmode($paymentmode)
    {
        $this->payment_mode= $paymentmode;
    }
    function get_paymentmode()
    {
        return $this->payment_mode;
    }

    function set_paymentdescription($paymentdescription)
    {
        $this->payment_description= $paymentdescription;
    }
    function get_paymentdescription()
    {
        return $this->payment_description;
    }

    function set_paymentid($paymentid)
    {
        $this->payment_id= $paymentid;
    }
    function get_paymentid()
    {
        return $this->payment_id;
    }

    function set_paymentplan($paymentplan)
    {
        $this->payment_plan= $paymentplan;
    }
    function get_paymentplan()
    {
        return $this->payment_plan;
    }

    function set_duedate($duedate)
    {
        $this->due_date= $duedate;
    }
    function get_duedate()
    {
        return $this->due_date;
    }

    function set_chequeimg($chequeimg)
    {
        $this->cheque_img= $chequeimg;
    }
    function get_chequeimg()
    {
        return $this->cheque_img;
    }

    function set_paymentreceipt($paymentreceipt)
    {
        $this->payment_receipt= $paymentreceipt;
    }
    function get_paymentreceipt()
    {
        return $this->payment_receipt;
    }

    function set_RTGSno($RTGSno)
    {
        $this->RTGS_no= $RTGSno;
    }
    function get_RTGSno()
    {
        return $this->RTGS_no;
    }

    function set_modifiedby($modifiedby)
    {
        $this->modified_by= $modifiedby;
    }
    function get_modifiedby()
    {
        return $this->modified_by;
    }


    public function jsonSerialize()
    {
        return [
            
                'paymentid' => $this->payment_id,
                'custid' =>$this->customer_id,
                'custname' => $this->customer_name,
                'custcontactnumber' =>$this->customer_contactnumber,
                'totalamt' =>$this->total_amount,
                'paidamt' =>$this->paid_amount,
                'pendingamt' =>$this->pending_amount,
                'paymentplan' =>$this->payment_plan,
                'paymentmode' =>$this->payment_mode,
                'RTGSno'=>$this->RTGS_no,
                'chequeimg'=>$this->cheque_img,
                'duedate'=>$this->due_date,
                'paymentdescription' =>$this->payment_description,
                'paymentreceipt' =>$this->payment_receipt,


            
        ];
    }
}
