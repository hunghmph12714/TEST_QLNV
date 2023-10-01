<?php
class Nhanvien {
    private $conn;
    private $table_name = "staffs";

    public $id;
    public $fullname;
    public $phone;
    public $email;
    public $introduce;
    public $start_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET fullname=:fullname, phone=:phone, email=:email, introduce=:introduce, start_date=:start_date";
        $stmt = $this->conn->prepare($query);
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->introduce = htmlspecialchars(strip_tags($this->introduce));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":introduce", $this->introduce);
        $stmt->bindParam(":start_date", $this->start_date);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET fullname=:fullname, phone=:phone, email=:email, introduce=:introduce, start_date=:start_date
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->introduce = htmlspecialchars(strip_tags($this->introduce));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":introduce", $this->introduce);
        $stmt->bindParam(":start_date", $this->start_date);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->fullname = $row['fullname'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
        $this->introduce = $row['introduce'];
        $this->start_date = $row['start_date'];
    }
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}
