<?php
class SupplierPayment  implements JsonSerializable
{
    private $supplier_name;
    private $supplierId;
    private $supplierpaymentId;
    private $POID;
    private $total_amount;
    private $paid_amount;
    private $pending_amount;
    private $received_amount;
    private $payment_mode;
    private $payment_description;
    private $payment_plan;
    private $due_date;
    private $cheque_img;
    private $RTGS_no;
    private $payment_receipt;
    private $modified_by;
    private $modifieddate;
    private $POCode;
    private $SupplierAddress;
    private $paymentPDFName;

    private $table_name = "supplierpaymentinfo";

    function set_supplierId($supplierId)
    {
        $this->supplierId= $supplierId;
    }
    function get_supplierId()
    {
        return $this->supplierId;
    }

    function set_supplierpaymentId($supplierpaymentId)
    {
        $this->supplierpaymentId= $supplierpaymentId;
    }
    function get_supplierpaymentId()
    {
        return $this->supplierpaymentId;
    }


    function set_supplierAddress($supplierAddress)
    {
        $this->SupplierAddress= $supplierAddress;
    }
    function get_supplierAddress()
    {
        return $this->SupplierAddress;
    }

    function setPOID($POID)
    {
        $this->POID= $POID;
    }
    function getPOID()
    {
        return $this->POID;
    }
    function setPOCode($POCode)
    {
        $this->POCode= $POCode;
    }
    function getPOCode()
    {
        return $this->POCode;
    }

    function set_suppliername($suppliername)
    {
        $this->suppliername= $suppliername;
    }
    function get_suppliername()
    {
        return $this->suppliername;
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


    function set_receivedamt($receivedamt)
    {
        $this->received_amount= $receivedamt;
    }
    function get_receivedamt()
    {
        return $this->received_amount;
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

    // function set_paymentreceipt($paymentreceipt)
    // {
    //     $this->payment_receipt= $paymentreceipt;
    // }
    // function get_paymentreceipt()
    // {
    //     return $this->payment_receipt;
    // }

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
    function set_modifieddate($modifieddate)
    {
        $this->modifieddate= $modifieddate;
    }
    function get_modifieddate()
    {
        return $this->modifieddate;
    }
    public function set_paymentPDFName($paymentPDFName){
        $this->paymentPDFName=$paymentPDFName;
    }
    public function get_paymentPDFName(){
       return $this->paymentPDFName;
    }

    
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'supplierpaymentId' => $this->supplierpaymentId,
                'supplierId' =>$this->supplierId,
                'suppliername' => $this->supplier_name,
                'totalamt' =>$this->total_amount,
                'paidamt' =>$this->paid_amount,
                'pendingamt' =>$this->pending_amount,
                'receivedamt' =>$this->received_amount,
                'paymentplan' =>$this->payment_plan,
                'paymentmode' =>$this->payment_mode,
                'RTGSno'=>$this->RTGS_no,
                'chequeimg'=>$this->cheque_img,
                'duedate'=>$this->due_date,
                'paymentdescription' =>$this->payment_description,
                'paymentreceipt' =>$this->payment_receipt,
                'POID'=>$this->POID,
                'POCode'=>$this->POCode,
                'SupplierAddress'=>$this->SupplierAddress,
                'paymentPDFName'=>$this->paymentPDFName,
        ];
    }
}
