<?php

const BOOK_DB = './db/books.json';
const MEMBER_DB = './db/members.json';
const ISSUANCE_DB = './db/issuance.json';

require_once './book.php';
require_once './member.php';
require_once './issuance.php';
require_once './utils.php';

class Library
{
    private $books = [];
    private $members = [];
    private $issuances = [];

    public function __construct()
    {
        $this->books = array_map('Book::toBook', loadDB(BOOK_DB));
        $this->members = array_map('Member::toMember', loadDB(MEMBER_DB));
        $this->issuances = array_map('Issuance::toIssuance', loadDB(ISSUANCE_DB));
    }

    public function addBook($title, $author)
    {
        $book = new Book($title, $author);
        $this->books[] = $book;
        saveToDB(BOOK_DB, $this->books);
        echo "Book added\n";
    }

    public function addMember($name, $address)
    {
        $member = new Member($name, $address);
        $this->members[] = $member;
        saveToDB(MEMBER_DB, $this->members);
        echo "Member added\n";
    }

    public function issueBook($bookId, $memberId)
    {
        $issuance = new Issuance($bookId, $memberId);
        $this->issuances[] = $issuance;
        saveToDB(ISSUANCE_DB, $this->issuances);
        echo "Book issued\n";
    }

    public function returnBooks($issuanceIds)
    {
        foreach ($this->issuances as $issuance) {
            if (array_search($issuance->id, $issuanceIds) !== false) {
                $issuance->markReturned();
            }
        }

        saveToDB(ISSUANCE_DB, $this->issuances);
        echo "Book returned\n";
    }

    public function showBooks($books = null)
    {
        $booksToShow = $books ?? $this->books;
        Book::showHead();
        foreach ($booksToShow as $index => $book) {
            $book->show($index + 1);
        }
        echo "\n";
    }

    public function showMembers($members = null)
    {
        Member::showHead();
        $membersToShow = $members ?? $this->members;
        foreach ($membersToShow as $index => $member) {
            $member->show($index + 1);
        }
        echo "\n";
    }

    public function showIssuances($issuances = null)
    {
        $issuancesToShow = $issuances ?? $this->issuances;
        Issuance::showHead();
        foreach ($issuancesToShow as $index => $issuance) {
            $issuance->show($index + 1);
        }
        echo "\n";
    }

    public function getBooks($bookName)
    {
        return  array_values(array_filter($this->books, fn($book) => strpos(strtolower($book->title), strtolower($bookName)) !== false));
    }

    public function isBookExists($bookId)
    {
        return array_search($bookId, array_column($this->books, 'id')) !== false;
    }

    public function getMembers($memberName)
    {
        return  array_values(array_filter($this->members, fn($member) => strpos(strtolower($member->name), strtolower($memberName)) !== false));
    }

    public function isMemberExists($memberId)
    {
        return array_search($memberId, array_column($this->members, 'id')) !== false;
    }

    public function getIssuances($memberId = null, $bookId = null, $status = null)
    {
        $getQuery = function ($issuance) use ($memberId, $bookId, $status) {
            return (!$memberId || $issuance->memberId === $memberId)
                && (!$bookId || $issuance->bookId === $bookId) &&
                (!$status || $issuance->status === $status);
        };

        return array_values(
            array_filter($this->issuances, $getQuery)
        );
    }

    public function getFees($issuanceIds)
    {
        $fees = [];
        foreach ($this->issuances as $issuance) {
            if (array_search($issuance->id, $issuanceIds) !== false) {
                $fees[$issuance->id] = $issuance->calculateFees();
            }
        }
        return $fees;
    }
}
