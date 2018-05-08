<?php
class ConnectDb {
    // Hold the class instance.
    private static $instance = null;
    // connection params
    private $conn;
    private $host = '127.0.0.1';
    private $dbname   = 'project';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';

    // The db connection is established in the private constructor.
    private function __construct()
    {
      try {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $this->conn = new PDO($dsn, $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      }
      Catch (PDOException $e) {
        echo '<pre>';
        echo "Error ({$e->getCode()}):<br> {$e->getMessage()}<br>";
        //print_r($e);
        print_r(debug_backtrace());
        echo '</pre>';
        die;
        // $e = new ErrorView([
        //   'message' => $e->getMessage(),
        //   'code' => $e->getCode()
        // ]);
      }
    }

    public static function getInstance()
    {
      if(!self::$instance)
      {
        self::$instance = new ConnectDb();
      }

      return self::$instance;
    }

    public function getConnection()
    {
      return $this->conn;
    }

  }
?>