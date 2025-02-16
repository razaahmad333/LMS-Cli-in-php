<?php
class CLI
{
    private $library;

    public function __construct($library)
    {
        $this->library = $library;
    }

    public static function guide()
    {
        echo "Welcome to library management system" . PHP_EOL;
        echo "Guide" . PHP_EOL;

        echo "  To add book:       php index.php add-book " . PHP_EOL;
        echo "  To list book:      php index.php list-book " . PHP_EOL;
        echo "  To add member:     php index.php add-member " . PHP_EOL;
        echo "  To list member:    php index.php list-member " . PHP_EOL;
        echo "  To issue book:     php index.php issue-book " . PHP_EOL;
        echo "  To return book:    php index.php return-book " . PHP_EOL;
        echo "  To list issuances: php index.php list-issuances " . PHP_EOL;
    }


    function addBook()
    {
        echo "Adding a book...\n";

        echo "Title: ";
        $title = trim(readline());

        echo "Author: ";
        $author = trim(readline());

        $this->library->addBook($title, $author);
    }

    function listBook()
    {
        echo "\n";
        $this->library->showBooks();
    }


    function addMember()
    {
        echo "Adding a member...\n";

        echo "Name: ";
        $name = trim(readline());

        echo "Address: ";
        $address = trim(readline());

        $this->library->addMember($name, $address);
    }

    function listMember()
    {
        echo "\n";
        $this->library->showMembers();
    }

    function getMemberId()
    {

        echo "Member Name: ";
        $memberName = trim(readline());

        $members = $this->library->getMembers($memberName);

        if (count($members) === 0) {
            echo "No members found\n";
            exit(1);
        }

        $this->library->showMembers($members);

        echo "Provide Member Id \n";
        $memberId = trim(readline());

        if (!$this->library->isMemberExists($memberId)) {
            echo "Member with id {$memberId} does not exists\n";
            exit(1);
        }

        return $memberId;
    }

    function getBookId()
    {
        echo "Book Name: ";
        $bookName = trim(readline());

        $books = $this->library->getBooks($bookName);

        if (count($books) === 0) {
            echo "No books found\n";
            exit(1);
        }

        $this->library->showBooks($books);

        echo "Provide Book Id \n";
        $bookId = trim(readline());

        if (!$this->library->isBookExists($bookId)) {
            echo "Book with id {$bookId} does not exists\n";
            exit(1);
        }

        return $bookId;
    }

    function issueBook()
    {
        echo "Issue a book...\n";


        $bookId = $this->getBookId($this->library);

        $memberId = $this->getMemberId($this->library);

        $this->library->issueBook($bookId, $memberId);
    }

    function returnBook()
    {
        echo "Return a book...\n";

        $memberId = $this->getMemberId($this->library);

        $issuances = $this->library->getIssuances($memberId, null, "ISSUED");

        if (count($issuances) === 0) {
            echo "No book issued to this member\n";
            exit(1);
        }

        $this->library->showIssuances($issuances);

        echo "Provide issuance Id (comma separated when multiple )\n";

        $idstring = trim(readline());

        $ids = array_map('trim', explode(',', $idstring));

        $fees = $this->library->getFees($ids);

        foreach ($fees as $id => $fee) {
            echo "Fees($id) : $$fee\n";
        }

        $this->library->returnBooks($ids);
    }

    function listIssuances()
    {
        $status = null;
        echo "Status (i -> ISSUED, r -> RETURNED ) : ";
        $flag = trim(readline());

        if ($flag === 'i') {
            $status = 'ISSUED';
        } else if ($flag === 'r') {
            $status = 'RETURNED';
        }

        $issuances = $this->library->getIssuances(null, null, $status);
        $this->library->showIssuances($issuances);
    }

    function init($argv)
    {
        $command = $argv[1];

        switch ($command) {
            case 'add-book':
                $this->addBook();
                break;
            case 'list-book':
                $this->listBook();
                break;
            case 'add-member':
                $this->addMember();
                break;
            case 'list-member':
                $this->listMember();
                break;
            case 'issue-book':
                $this->issueBook();
                break;
            case 'return-book':
                $this->returnBook();
                break;
            case 'list-issuances':
                $this->listIssuances();
                break;
        }
    }
}
