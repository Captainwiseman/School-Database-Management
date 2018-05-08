<?php

class School {
// main login page, nothing logged nothing posted
  public function main($error = null) {
    $v = new PageView();
    $v->setError($error);
    $v->setComponent("login.php");
    $v->dump();
  }
  public function login() {
    $error = "";
    // if a user is not logged and tried a log-in
    if(empty($_SESSION['logged']) && isset($_POST['email'])) {
      $u = new user();
      // if a user's hash is not validated he is thrown back to the login page with an BAD LOGIN ERROR
        if ($u->dologin($_POST['email']) == false) {
          $error = "Bad LOGIN";
          $this->main($error);
        }
    }
    if (isset($_SESSION['logged'])) {
      header("location: ./school");
    }
    // if a person is trying to access the /login route and he is not logged nor trying to log-in
    // than he is thrown back to the login route with an error
    else {
      if ($error == "") {
        $error = "Unauthorized Access Call, Please Report Yourself";
        $this->main($error);
      }
    }
  }
  // main school page. logged users only
  public function logged() {
    $error = "";
    // if a user is logged, a logged session is intiated
    if (isset($_SESSION['logged'])) {
      $s = new schoolmodel;
      $data = [
        "logged"=> Session::logged(),
        "courses" => $s->getAllCourses(),
        "students" => $s->getAllStudents()
      ];
      // setting nav buttons view according to the role of the user
      $v = new PageView();
      if ($data['logged']['role'] == "Owner" || $data['logged']['role'] == "Manager") {
        $v->setNav(true,true);
      }
      if ($data['logged']['role'] == "Sales") {
        $v->setNav(true,false);
      }
      $v->addJs('school.js');
      $v->setActive("school");
      $v->setComponent("school.php", $data);
      $v->dump();
    }
    // if a person is trying to access the /school route and he is not logged nor trying to log-in
    // than he is thrown back to the login route with an error
    else {
      if ($error == "") {
        $error = "Unauthorized Access Call, Please Report Yourself";
      }
      $this->main($error);
    }
  }
  public function admin() {
    $error = "";
    // if a user is logged, a logged session is intiated
    if (isset($_SESSION['logged'])) {
      $s = new schoolmodel;
      $data = [
        "logged"=> Session::logged(),
        "courses" => $s->getAllCourses(),
        "students" => $s->getAllStudents()
      ];
      // setting nav buttons view according to the role of the user and admin validation
      $v = new PageView();
      if ($data['logged']['role'] == "Owner" || $data['logged']['role'] == "Manager") {
        $v->setNav(true,true);
      }
      else if ($data['logged']['role'] == "Sales") {
        $v->setNav(true,false);
      }
      else {
        $error = "Unauthorized Access Call,ADMINS ONLY, Please Report Yourself";
      $this->main($error);
    }
      $v->addJs('admin.js');
      $v->setActive("admin");
      $v->setComponent("admin.php", $data);
      $v->dump();
    }
    // if a person is trying to access the /admin route and he is not logged nor trying to log-in
    // than he is thrown back to the login route with an error
    else {
      if ($error == "") {
        $error = "Unauthorized Access Call, Please Report Yourself";
      }
      $this->main($error);
    }
  }
}