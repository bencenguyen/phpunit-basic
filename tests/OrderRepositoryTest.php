<?php

use App\Order;
use App\OrderRepository;
use App\NoSuchElementException;
use PHPUnit\Framework\TestCase;
use App\UniqueKeyViolationException;

class OrderRepositoryTest extends TestCase
{

    private $pdo;

    private $underTest;

    public function __construct()
    {
        parent::__construct();
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function setUp(): void
    {
        $this->pdo->exec("CREATE TABLE orders (id int(11), username VARCHAR(60), email VARCHAR(255), address VARCHAR(255), PRIMARY KEY(id))");
        $this->underTest = new OrderRepository($this->pdo);
    }

    public function tearDown(): void
    {
        $this->pdo->exec("DROP TABLE orders");
    }

    public function test()
    {
        $this->assertTrue(true);
    }


    /**
     * @test
     */
    public function it_should_throw_no_such_element_exception_when_no_element_is_found()
    {
        $this->expectException(NoSuchElementException::class);
        $this->underTest->findOrder(5);
    }

    /**
     * @test
     */
    public function it_should_return_created_element_when_found()
    {
        $id       = 5;
        $address  = "address";
        $username = "username";
        $email    = "email@email.com";
        $order    = new Order($id, $username, $address, $email);

        $this->underTest->createOrder($order);
        $actual = $this->underTest->findOrder($id);

        $this->assertEquals($actual->getId(), $id);
        $this->assertEquals($actual->getUsername(), $username);
        $this->assertEquals($actual->getEmail(), $email);
        $this->assertEquals($actual->getAddress(), $address);
    }

    public function testShouldNotAllowMultipleOccuranceOfTheSameId()
    {
        $id       = 5;
        $address  = "address";
        $username = "username";
        $email    = "email@email.com";
        $order    = new Order($id, $address, $username, $email);

        $this->underTest->createOrder($order);

        $this->expectException(UniqueKeyViolationException::class);
        $this->underTest->createOrder($order);
    }

    public function testShouldThrowNoSuchElementExceptionWhenNoElementToBeDeleted()
    {
        $id = 5;

        $this->expectException(NoSuchElementException::class);
        $this->underTest->remove($id);
    }

    public function testShouldDeleteExistingElement()
    {
        $id       = 5;
        $address  = "address";
        $username = "username";
        $email    = "email@email.com";
        $order    = new Order($id, $address, $username, $email);

        $this->underTest->createOrder($order);

        $this->underTest->remove($id);
        $this->expectException(RuntimeException::class);

        try {
            $this->underTest->findOrder($id);
        } catch (Exception $ex) {
            throw new RuntimeException();
        }

    }
}