    <?php
    class Database
    {
        private $host = "localhost";
        private $db_name = "qlnv";
        private $username = "root";
        private $password = "";
        public $conn;

        public function getConnection()
        {
            $this->conn = null;

            try {
                $this->conn  = new  PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8', $this->username, $this->password);
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                echo "Lỗi kết nối cơ sở dữ liệu: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
    ?>
