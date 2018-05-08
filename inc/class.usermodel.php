<?php

class usermodel {

  function __construct() {
    $instance = ConnectDb::getInstance();
    $this->conn = $instance->getConnection();
  }

  function getAllUsers() {
    $sql = "SELECT * FROM administrator";
    try {
      $ret = [];
      $query = $this->conn->query($sql);
      while($line = $query->fetch()) {
        $ret[$line['name']] = [
          'name' => $line['name'],
          'role' => $line['role'],
          'id' => $line['adminid'],
          'phone' => $line['phone'],
          'email' => $line['email'],
          'img' => $line['image']
        ];
      }
      return $ret;
    }
    Catch (PDOException $e) {
      $f = new ErrorView([
        'message' => $e->getMessage(),
        'code' => $e->getCode()
      ]);
    }
  }

  function getUserByMail($email) {
    global $conn;
    $sql = "select * from administrator where email = '$email'";
    try {
      $result = $this->conn->query($sql);
      return $result->fetch();
    }
    Catch (PDOException $e) {
        echo 'DB ERROR: '.$e->getMessage();
        die;
    }
  }
  function getUser($id) {
    $sql = "SELECT * FROM administrator WHERE adminid = {$id}";
    try {
      $ret = [];
      $query = $this->conn->query($sql);
      while($line = $query->fetch()) {
        $ret = [
          'name' => $line['name'],
          'id' => $line['adminid'],
          'role' => $line['role'],
          'phone' => $line['phone'],
          'email' => $line['email'],
          'img' => $line['image']
          ];
        }
    return $ret;
    }
    Catch (PDOException $e) {
      $f = new ErrorView([
        'message' => $e->getMessage(),
        'code' => $e->getCode()
      ]);
    }
  }
  function addUser($id,$name,$password,$phone,$email,$role,$img) {
    if ($_SESSION['logged']['role'] == "Manager" || $_SESSION['logged']['role'] == "Owner") {
      $hash = $this->pwhash_create($password, 7);
      $sql = "INSERT INTO administrator(adminid,name,role,phone,image,email,hash) VALUES(:adminid,:name,:role,:phone,:image,:email,:hash)";
      try {
        $stmnt = $this->conn->prepare($sql);
          $params = [
            'adminid' => $id,
            'name' => $name,
            'role' => $role,
            'phone' => $phone,
            'image' => $img,
            'email' => $email,
            'hash' => $hash
            ];
            $stmnt->execute($params);
      }
      Catch (PDOException $e) {
        $f = new ErrorView([
          'message' => $e->getMessage(),
          'code' => $e->getCode()
        ]);
      }
    }
    else {
      return "Bad Access";
    }
  }
  function editUser($id,$name,$password,$phone,$email,$role,$img) {
    if ($_SESSION['logged']['role'] == "Manager" || $_SESSION['logged']['role'] == "Owner") {
      $hash = $this->pwhash_create($password, 7);
      $sql = "UPDATE administrator SET name=:name, role=:role, phone=:phone, image=:image, email=:email, hash=:hash WHERE adminid=:adminid";
      try {
        $stmnt = $this->conn->prepare($sql);
          $params = [
            'adminid' => $id,
            'name' => $name,
            'role' => $role,
            'phone' => $phone,
            'image' => $img,
            'email' => $email,
            'hash' => $hash
            ];
            $stmnt->execute($params);
      }
      Catch (PDOException $e) {
        $f = new ErrorView([
          'message' => $e->getMessage(),
          'code' => $e->getCode()
        ]);
      }
    }
    else {
      return "Bad Access";
    }
  }
  function deleteUser($id) {
    if ($_SESSION['logged']['role'] == "Manager" || $_SESSION['logged']['role'] == "Owner") {
      try {
        $sql = "DELETE FROM administrator WHERE adminid=:adminid";
        $stmnt = $this->conn->prepare($sql);
        $params = [
            'adminid' => $id
        ];
        $stmnt->execute($params);
        if($stmnt->rowCount()==0) {
            $result['error'] = "Admin ID {$params['id']} does not exist";
        }
        else {
            $result = [
                'success' => TRUE
            ];
        }
      }
      Catch (PDOException $e) {
        $result['error'] = 'DB ERROR: '.$e->getMessage();
      }
    }
    else {
      return "Bad Access";
    }
  }
  function pwhash_create($password,$cost) {
    $crypt_options = array(
        'cost' => $cost
    );
    $hash = password_hash($password, PASSWORD_BCRYPT, $crypt_options);
    return $hash;
  }

  function pwhash_test($password,$hash) {
      $result = password_verify($password, $hash);
      return $result;
  }
}