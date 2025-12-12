<?php
class Company
{
    private $company_name;
    private $company_address;
    private $company_contact;
    private $company_tag;
    private $company_branches;
    private $company_email;
    private $password;
    private $company_id;
    private $company_GSTIN;
    private $company_BankName;
    private $company_BankAccountNumber;
    private $company_BankIFSC;
    function set_id($id)
    {
        $this->company_id = $id;
    }
    function get_id()
    {
        return $this->company_id;
    }

    function set_companyname($companyname)
    {
        $this->company_name = $companyname;
    }
    function get_companyname()
    {
        return $this->company_name;
    }

    function set_companycontact($companycontact)
    {
        $this->company_contact = $companycontact;
    }
    function get_companycontact()
    {
        return $this->company_contact;
    }

    function set_companyemail($companyemail)
    {
        $this->company_email = $companyemail;
    }
    function get_companyemail()
    {
        return $this->company_email;
    }

    function set_companypassword($companypassword)
    {
        $this->password = $companypassword;
    }
    function get_companypassword()
    {
        return $this->password;
    }


    function set_companytag($companytag)
    {
        $this->company_tag = $companytag;
    }
    function get_companytag()
    {
        return $this->company_tag;
    }

    function set_companybranches($companybranches)
    {
        $this->company_branches = $companybranches;
    }
    function get_companybranches()
    {
        return $this->company_branches;
    }

    function set_companyaddress($companyaddress)
    {
        $this->company_address = $companyaddress;
    }
    function get_companyaddress()
    {
        return $this->company_address;
    }
    function set_companyGSTIN($companyGSTIN)
    {
        $this->company_GSTIN = $companyGSTIN;
    }
    function get_companyGSTIN()
    {
        return $this->company_GSTIN;
    }
    function set_companyBankName($companyBankName)
    {
        $this->company_BankName = $companyBankName;
    }
    function get_companyBankName()
    {
        return $this->company_BankName;
    }
    function set_companyBankAccountNumber($companyBankAccountNumber)
    {
        $this->company_BankAccountNumber = $companyBankAccountNumber;
    }
    function get_companyBankAccountNumber()
    {
        return $this->company_BankAccountNumber;
    }
    function set_companyBankIFSC($companyBankIFSC)
    {
        $this->company_BankIFSC = $companyBankIFSC;
    }
    function get_companyBankIFSC()
    {
        return $this->company_BankIFSC;
    }
}
