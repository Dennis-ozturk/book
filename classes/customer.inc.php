<?php


class Customer
{
    private $db;
    protected $transaction;
    public function __construct()
    {
        $this->transaction = new Transaction;
        $this->db = new DB();
        $this->db = $this->db->connect();
    }

    public function checkCustomerExists($data)
    {
        $stmt = $this->db->prepare("SELECT id FROM customer WHERE email = :email");
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_INT);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if ($id) {
            return $id;
        } else {
            $this->addCustomer($data);
            return false;
        }
    }

    public function addCustomer($data)
    {
        $stmt = $this->db->prepare("INSERT INTO customer (id, firstname, lastname, email, address, state, zip, country, phone) VALUES (:id, :firstname, :lastname, :email, :address, :state, :zip, :country, :phone)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }
        if ($stmt->execute()) { }
    }
}
