<?php

class Contact {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

     public function createContact($fullname, $email, $message)
    {
        $fullname = mysqli_real_escape_string($this->conn, $fullname);
        $email = mysqli_real_escape_string($this->conn, $email);
        $message = mysqli_real_escape_string($this->conn, $message);

        $query = "INSERT INTO contacts (fullname, email, message, created_at) 
                  VALUES ('$fullname', '$email', '$message', NOW())";

        return mysqli_query($this->conn, $query);
    }

    public function getAll() {
        $query = "SELECT * FROM contacts ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $query);

        $contacts = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $contacts[] = $row;
        }

        return $contacts;
    }
}
