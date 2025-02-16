<?php

require_once './utils.php';

class Book
{
    public $id;
    public $title;
    public $author;

    public function __construct($title, $author, $id = null)
    {
        if ($id) {
            $this->id = $id;
        } else {
            $this->id = generateID(4, true);
        }
        $this->title = $title;
        $this->author = $author;
    }

    public static function showHead()
    {
        printf("\e[1;32m%-15s %-20s %-20s\e[0m\n", "Sr. Book Id", "Title", "Author");
    }
    
    public function show($sr)
    {
        printf("%-15s %-20s %-20s\n", $sr.".  ".$this->id, $this->title, $this->author);
    }

    public static function toBook($bookData)
    {
        [
            'id' => $id,
            'title' => $title,
            'author' => $author,
        ] = $bookData;

        return new Book($title, $author, $id);
    }
}
