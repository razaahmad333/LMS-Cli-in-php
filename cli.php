<?php

require_once './book.php';

$library = require_once './library.php';

function printGuide()
{
    echo "Welcome to library management system" . PHP_EOL;
    echo "Guide".PHP_EOL;

    echo "  To add book:       php index.php add-book " . PHP_EOL;
    echo "  To list book:      php index.php list-book " . PHP_EOL;
    echo "  To add member:     php index.php add-member " . PHP_EOL;
    echo "  To list member:    php index.php list-member " . PHP_EOL;
    echo "  To issue book:     php index.php issue-book " . PHP_EOL;
    echo "  To return book:    php index.php return-book " . PHP_EOL;
    echo "  To list issuances: php index.php list-issuances " . PHP_EOL;
}

function addBook($library)
{
    echo "Adding a book...\n";

    echo "Title: ";
    $title = trim(readline());

    echo "Author: ";
    $author = trim(readline());

    $library->addBook($title, $author);
}

function listBook($library)
{
    echo "\n";
    $library->showBooks();
}


function addMember($library)
{
    echo "Adding a member...\n";

    echo "Name: ";
    $name = trim(readline());

    echo "Address: ";
    $address = trim(readline());

    $library->addMember($name, $address);
}

function listMember($library)
{
    echo "\n";
    $library->showMembers();
}

function getMemberId($library){

    echo "Member Name: ";
    $memberName = trim(readline());

    $members = $library->getMembers($memberName);

    if(count($members)===0){
        echo "No members found\n";
        exit(1);
    }

    $library->showMembers($members);

    echo "Provide Member Id \n";
    $memberId = trim(readline());

    if(!$library->isMemberExists($memberId)){
        echo "Member with id {$memberId} does not exists\n";
        exit(1);
    }

    return $memberId;
}

function getBookId($library){
    echo "Book Name: ";
    $bookName = trim(readline());

    $books = $library->getBooks($bookName);
    
    if(count($books) === 0){
        echo "No books found\n";
        exit(1);
    }

    $library->showBooks($books);

    echo "Provide Book Id \n";
    $bookId = trim(readline());

    if(!$library->isBookExists($bookId)){
        echo "Book with id {$bookId} does not exists\n";
        exit(1);
    }

    return $bookId;
}

function issueBook($library){
    echo "Issue a book...\n";

  
    $bookId = getBookId($library);

    $memberId = getMemberId($library);

    $library->issueBook($bookId, $memberId);
}

function returnBook($library){
    echo "Return a book...\n";

    $memberId = getMemberId($library);

    $issuances = $library->getIssuances($memberId);

    if(count($issuances)===0){
        echo "No book issued to this member\n";
        exit(1);
    }

    $library->showIssuances($issuances);

    echo "Provide issuance Id (comma separated when multiple )\n";

    $idstring = trim(readline());

    $ids = array_map('trim', explode(',', $idstring));

    $library->returnBooks($ids);

}

function listIssuances($library){
    echo "\n";
    $library->showIssuances();
}
    
if ($argc > 1) {
    $command = $argv[1];

    switch ($command) {
        case 'add-book':
            addBook($library);
            break;
        case 'list-book':
            listBook($library);
            break;
        case 'add-member':
            addMember($library);
            break;
        case 'list-member':
            listMember($library);
            break;
        case 'issue-book':
            issueBook($library);
            break;
        case 'return-book':
            returnBook($library);
            break;
        case 'list-issuances':
            listIssuances($library);
            break;
    }
} else {
    printGuide();
}
