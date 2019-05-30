<?php


class Transaction
{
    private $db;
    public function __construct()
    {
        $this->db = new DB();
        $this->db = $this->db->connect();
    }


    public function addTransaction($data, $id = null)
    {
        $stmt = $this->db->prepare("INSERT INTO transactions (id, customer_id, product, amount, currency, status) VALUES (:id, :customer_id, :product, :amount, :currency, :status)");

        foreach($data as $key => $value){
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }
        if($stmt->execute()){
        }
    }
}
