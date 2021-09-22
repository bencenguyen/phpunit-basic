<?php

namespace App;

use PDOException;

class OrderRepository
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createOrder(Order $order)
    {
        $statement = $this->pdo->prepare("INSERT INTO orders (id, address, username, email)
        VALUES (:id, :address, :username, :email)");

        try {
            $statement->execute([
                "id"       => $order->getId(),
                "address"  => $order->getAddress(),
                "username" => $order->getUsername(),
                "email"    => $order->getEmail()
            ]);
        } catch (PDOException $ex) {
            if ($ex->getCode() == 23000) throw new UniqueKeyViolationException($order->getId(), $ex);

            throw $ex;
        }
    }

    public function findOrder(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $statement->execute(["id" => $id]);

        $row = $statement->fetch();

        if (!$row) throw new NoSuchElementException($id);

        return new Order($row["id"], $row["username"], $row["address"], $row["email"]);
    }

    public function remove($id)
    {
        $this->findOrder($id);

        $statement = $this->pdo->prepare("DELETE FROM orders WHERE id = :id");
        $statement->execute(["id" => $id]);
    }
}
