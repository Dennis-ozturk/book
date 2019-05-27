<?php
class Api
{
    private $db;
    public function __construct()
    {
        $this->db = new DB();
        $this->db = $this->db->connect();
    }

    public function getApiData()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "http://face-saving-compres.000webhostapp.com/request.php?books&api=7153d47ddcaf8a1b1bc6768bee40e6f8",
            CURLOPT_USERAGENT => 'Curl Request'
        ]);
        $resp = curl_exec($curl);

        if ($resp) {
            $json = substr($resp, 18);
            $books = json_decode($json, true);
            return $books;
            curl_close($curl);
        } else {
            print_r("Something went wrong");
            curl_close($curl);
        }
    }

    public function insertStripeUser($user_info)
    {
        $stmt = $this->db->prepare('INSERT INTO customer(firstname, lastname, email, address, state, zip, country, phone) VALUES (:firstname, :lastname, :email, :address, :state, :zip, :country, :phone)');
        foreach ($user_info as $key => $value) {
            if ($key === 'zip') {
                $stmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
            }
        }

        if($stmt->execute()){
            echo("Success");
        }else {
            echo("Something went wrong");
        }
    }

    public function payment()
    { }
}
