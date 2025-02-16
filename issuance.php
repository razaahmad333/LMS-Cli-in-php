<?php

require_once './utils.php';

class Issuance
{
    public $id;
    public $bookId;
    public $memberId;
    public $issuedAt;
    public $returnedAt;
    public $status;

    public function __construct($bookId, $memberId, $extraData = null)
    {
        $this->id = $extraData && $extraData['id'] ? $extraData['id'] : generateID();
        $this->issuedAt = $extraData && $extraData['issuedAt'] ? $extraData['issuedAt'] : time();
        $this->returnedAt =  $extraData['returnedAt'] ?? null;
        $this->status = $extraData && $extraData['status'] ? $extraData['status'] : 'ISSUED';
      
        $this->bookId = $bookId;
        $this->memberId = $memberId;
    }

    public static function showHead()
    {
        printf("\e[1;32m%-15s %-20s %-20s %-20s %-20s \e[0m\n", "Sr. Issue Id", "Book", "Member", "Status", "Issued At");
    }


    public function show($sr)
    {
        printf("%-15s %-20s %-20s %-20s %-20s\n",  $sr . ".  " . $this->id, $this->bookId, $this->memberId, $this->status, date('d/m/y h:m:s', $this->issuedAt));
    }

    public function markReturned()
    {
        $this->status = "RETURNED";
        $this->returnedAt = time();
    }

    public static function toIssuance($issuanceData)
    {
        return  new Issuance($issuanceData['bookId'], $issuanceData['memberId'], $issuanceData);
    }
}
