<?php
class Invoice implements JsonSerializable
{
    private $invoiceId;
    private $invoiceDate;
    private $invoiceNumber;
    private $dispatchThrough;
    private $destination;
    private $clientName;
    private $address;
    private $location;
    private $contact;
    private $gst;
    private $igst;

    private $vehicleNo;

    private $items = [];
    private $totalAmount = 0;

    public function setVehicleNo($value)
    {
        $this->vehicleNo = $value;
        return $this;
    }

    public function getVehicleNo()
    {
        return $this->vehicleNo;
    }
    public function setInvoiceId($value)
    {
        $this->invoiceId = $value;
        return $this;
    }
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    public function setInvoiceDate($value)
    {
        $this->invoiceDate = $value;
        return $this;
    }
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    public function setInvoiceNumber($value)
    {
        $this->invoiceNumber = $value;
        return $this;
    }
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    public function setDispatchThrough($value)
    {
        $this->dispatchThrough = $value;
        return $this;
    }
    public function getDispatchThrough()
    {
        return $this->dispatchThrough;
    }

    public function setDestination($value)
    {
        $this->destination = $value;
        return $this;
    }
    public function getDestination()
    {
        return $this->destination;
    }

    public function setClientName($value)
    {
        $this->clientName = $value;
        return $this;
    }
    public function getClientName()
    {
        return $this->clientName;
    }

    public function setAddress($value)
    {
        $this->address = $value;
        return $this;
    }
    public function getAddress()
    {
        return $this->address;
    }

    public function setLocation($value)
    {
        $this->location = $value;
        return $this;
    }
    public function getLocation()
    {
        return $this->location;
    }

    public function setContact($value)
    {
        $this->contact = $value;
        return $this;
    }
    public function getContact()
    {
        return $this->contact;
    }

    public function setGst($value)
    {
        $this->gst = $value;
        return $this;
    }
    public function getGst()
    {
        return $this->gst;
    }
    public function setIgst($value)
    {
        $this->igst = $value;
        return $this;
    }

    public function getIgst()
    {
        return $this->igst;
    }
    public function setItems($value)
    {
        $this->items = $value;
        return $this;
    }
    public function getItems()
    {
        return $this->items;
    }

    public function setTotalAmount($value)
    {
        $this->totalAmount = $value;
        return $this;
    }
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'invoiceId' => $this->invoiceId,
            'invoiceDate' => $this->invoiceDate,
            'invoiceNumber' => $this->invoiceNumber,
            'dispatchThrough' => $this->dispatchThrough,
            'destination' => $this->destination,
            'clientName' => $this->clientName,
            'address' => $this->address,
            'location' => $this->location,
            'contact' => $this->contact,
            'vehicleNo' => $this->vehicleNo,
            'gst' => $this->gst,
            'igst' => $this->igst,
            'items' => $this->items,
            'totalAmount' => $this->totalAmount
        ];
    }
}
?>