<?php

require_once './utils.php';

class Member
{
    public $id;
    public $name;
    public $address;

    public function __construct($name, $address, $id = null)
    {
        if ($id) {
            $this->id = $id;
        } else {
            $this->id = generateID(4, true);
        }
        $this->name = $name;
        $this->address = $address;
    }

    public static function showHead(){
        printf("\e[1;32m%-15s %-20s %-20s\e[0m\n", "Sr. Member Id", "Name", "Address");
    }

    public function show($sr)
    {
        printf("%-15s %-20s %-20s\n", $sr.".  ".$this->id, $this->name, $this->address);
    }

    public static function toMember($bookData)
    {
        [
            'id' => $id,
            'name' => $name,
            'address' => $address,
        ] = $bookData;

        return new Member($name, $address, $id);
    }
}
