<?php

class schoolmodel {

  function __construct() {
    $instance = ConnectDb::getInstance();
    $this->conn = $instance->getConnection();
  }

  function getAllCourses() {
    $sql = "SELECT * FROM course";
    try {
      $ret = [];
      $query = $this->conn->query($sql);
      while($line = $query->fetch()) {
        $ret[$line['name']] = [
          'name' => $line['name'],
          'id' => $line['courseid'],
          'description' => $line['description'],
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
  function getAllStudents() {
    $sql = "SELECT * FROM student";
    try {
      $ret = [];
      $query = $this->conn->query($sql);
      while($line = $query->fetch()) {
        $ret[$line['name']] = [
          'name' => $line['name'],
          'id' => $line['studentid'],
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
  function getStudentByMail($email) {
    global $conn;
    $sql = "select * from student where email = '$email'";
    try {
      $result = $this->conn->query($sql);
      return $result->fetch();
    }
    Catch (PDOException $e) {
        echo 'DB ERROR: '.$e->getMessage();
        die;
    }
  }
  function getStudent($id) {
    $sql = "SELECT * FROM student WHERE studentid = {$id}";
    try {
      $ret = [];
      $query = $this->conn->query($sql);
      while($line = $query->fetch()) {
        $ret = [
          'name' => $line['name'],
          'id' => $line['studentid'],
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
  function getCourse($id) {
    $sql = "SELECT * FROM course WHERE courseid = {$id}";
      try {
        $ret = [];
        $query = $this->conn->query($sql);
        while($line = $query->fetch()) {
          $ret = [
            'name' => $line['name'],
            'id' => $line['courseid'],
            'description' => $line['description'],
            'img' => $line['image'],
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
  function getCourseStudents($id) {
      $sql = "SELECT * FROM studentcourses WHERE courseid = {$id}";
      try {
        $ret = [];
        $query = $this->conn->query($sql);
        while($line = $query->fetch()) {
          $student = $this->getStudent($line['studentid']);
          $ret[$line['studentid']] = [
            'studentid' => $line['studentid'],
            'name' => $student['name'],
            'img' => $student['img']
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
  function getStudentCourses($id) {
    $sql = "SELECT * FROM studentcourses WHERE studentid = {$id}";
    try {
      $ret = [];
      $query = $this->conn->query($sql);
      while($line = $query->fetch()) {
        $course = $this->getCourse($line['courseid']);
        $ret[$line['courseid']] = [
          'courseid' => $line['courseid'],
          'name' => $course['name'],
          'img' => $course['img']
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
  function addStudent($id,$name,$phone,$email,$courses,$img) {
    
    $sql = "INSERT INTO student(studentid,name,phone,email,image) VALUES(:studentid,:name,:phone,:email,:image)";
    try {
      $stmnt = $this->conn->prepare($sql);
        $params = [
          'studentid' => $id,
          'name' => $name,
          'phone' => $phone,
          'email' => $email,
          'image' => $img
          ];
          $stmnt->execute($params);
    }
    Catch (PDOException $e) {
      $f = new ErrorView([
        'message' => $e->getMessage(),
        'code' => $e->getCode()
      ]);
    }
    if ($courses) {
      foreach ($courses as $value) {
        $sql = "INSERT INTO studentcourses(studentid,courseid) VALUES(:studentid,:courseid)";
        try {
          $stmnt = $this->conn->prepare($sql);
            $params = [
              'studentid' => $id,
              'courseid' => $value
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
    }
  }
  function editStudent($id,$name,$phone,$email,$courses,$img) {
    $sql = "UPDATE student SET name=:name, phone =:phone, email=:email, image=:image WHERE studentid=:studentid";
    try {
      $stmnt = $this->conn->prepare($sql);
        $params = [
          'studentid' => $id,
          'name' => $name,
          'phone' => $phone,
          'email' => $email,
          'image' => $img
          ];
          $stmnt->execute($params);
    }
    Catch (PDOException $e) {
      $f = new ErrorView([
        'message' => $e->getMessage(),
        'code' => $e->getCode()
      ]);
    }
    try {
      $sql = "DELETE FROM studentcourses WHERE studentid=:studentid";
      $stmnt = $this->conn->prepare($sql);
      $params = [
          'studentid' => $id
      ];
      $stmnt->execute($params);
    }
    Catch (PDOException $e) {
      $result['error'] = 'DB ERROR: '.$e->getMessage();
    }
    if ($courses) {
      foreach ($courses as $value) {
        $sql = "INSERT INTO studentcourses(studentid,courseid) VALUES(:studentid,:courseid)";
        try {
          $stmnt = $this->conn->prepare($sql);
            $params = [
              'studentid' => $id,
              'courseid' => $value
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
    }
  }
  function deleteStudent($id) {
    try {
      $sql = "DELETE FROM studentcourses WHERE studentid=:studentid";
      $stmnt = $this->conn->prepare($sql);
      $params = [
          'studentid' => $id
      ];
      $stmnt->execute($params);
    }
    Catch (PDOException $e) {
      $result['error'] = 'DB ERROR: '.$e->getMessage();
    }
    try {
      $sql = "DELETE FROM student WHERE studentid=:studentid";
      $stmnt = $this->conn->prepare($sql);
      $params = [
          'studentid' => $id
      ];
      $stmnt->execute($params);
      if($stmnt->rowCount()==0) {
          $result['error'] = "Course ID {$params['id']} does not exist";
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
  function addCourse($name,$description,$img) {
    if ($_SESSION['logged']['role'] == "Manager" || $_SESSION['logged']['role'] == "Owner") {
      $sql = "INSERT INTO course(name,description,image) VALUES(:name,:description,:image)";
      try {
        $stmnt = $this->conn->prepare($sql);
          $params = [
            'name' => $name,
            'description' => $description,
            'image' => $img
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
  function editCourse($id,$name,$description,$img) { 
    if ($_SESSION['logged']['role'] == "Manager" || $_SESSION['logged']['role'] == "Owner") {
      $sql = "UPDATE course SET name =:name, description=:description,image=:image WHERE courseid=:courseid";
      try {
        $stmnt = $this->conn->prepare($sql);
          $params = [
            'courseid' => $id,
            'name' => $name,
            'description' => $description,
            'image' => $img
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
  function deleteCourse($id) {
    if ($_SESSION['logged']['role'] == "Manager" || $_SESSION['logged']['role'] == "Owner") {
      try {
        $sql = "DELETE FROM course WHERE courseid=:courseid";
        $stmnt = $this->conn->prepare($sql);
        $params = [
            'courseid' => $id
        ];
        $stmnt->execute($params);
        if($stmnt->rowCount()==0) {
            $result['error'] = "Course ID {$params['id']} does not exist";
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
  // last incremented ID for the courses
  function lastID() {
    $sql = "SELECT AUTO_INCREMENT
            FROM information_schema.tables
            WHERE table_name = 'course'";
    $query = $this->conn->query($sql);
    $lastid = $query->fetch()['AUTO_INCREMENT'] - 1;
    return $lastid;
  }
}