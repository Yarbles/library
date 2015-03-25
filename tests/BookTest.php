<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Patron.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Patron::deleteAll();
        }

        function test_getAuthor()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);

            //Act
            $result = $test_book->getAuthor();

            //Assert
            $this->assertEquals($author, $result);
        }

        function test_getTitle()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function test_getId()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setId()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = null;
            $test_book = new Book($author, $title, $id);

            //Act
            $test_book->setId(1);

            //Assert
            $result = $test_book->getId();
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);
            $test_book->save();

            //Act
            $result= Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);

        }

        function test_getAll()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);
            $test_book->save();

            $author2 = "Charles Dickens";
            $title2 = "Tale of Two Cities";
            $id2 = 2;
            $test_book2 = new Book ($author2, $title2, $id2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);
            $test_book->save();

            $author2 = "Charles Dickens";
            $title2 = "Tale of Two Cities";
            $id2 = 2;
            $test_book2 = new Book ($author2, $title2, $id2);
            $test_book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function test_find()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);
            $test_book->save();

            $author2 = "Charles Dickens";
            $title2 = "Tale of Two Cities";
            $id2 = 2;
            $test_book2 = new Book ($author2, $title2, $id2);
            $test_book2->save();

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function test_addPatron()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);
            $test_book->save();

            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id2 = 2;
            $test_patron = new Patron($name, $phone, $id2);
            $test_patron->save();

            //Act
            $test_book->addPatron($test_patron);

            //Assert
            $this->assertEquals($test_book->getPatrons(), [$test_patron]);
        }

        function test_getPatrons()
        {
            //Arrange
            $author = "Tom Clancy";
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($author, $title, $id);
            $test_book->save();

            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id2 = 2;
            $test_patron = new Patron($name, $phone, $id2);
            $test_patron->save();

            $name2 = "Jimmy John";
            $phone2 = "892-382-1910";
            $id3 = 3;
            $test_patron2 = new Patron($name2, $phone2, $id3);
            $test_patron2->save();

            //Act
            $test_book->addPatron($test_patron);
            $test_book->addPatron($test_patron2);

            //Assert
            $this->assertEquals($test_book->getPatrons(), [$test_patron, $test_patron2]);
        }

        //function test_update()

        //function test_deleteBook()

    }
?>
