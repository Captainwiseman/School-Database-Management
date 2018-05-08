<?php
require "inc/common.php";

$route = empty($_GET['route']) ? [] : explode('/',$_GET['route']);

if(count($route)>0) {
  if (count($route)<3) {
    $route[2] = null;
  }
    switch ($route[0]) {
      case 'login':
      $s = new School();
      $s->login();
      break;
      case 'admin':
      $s = new School();
      $s->admin();
      break;
      case 'school':
      $s = new School();
      $s->logged();
      break;
      case 'api':
        switch ($route[1]) {
          case 'students':
            switch ($route[2]) {
              case null:
              $a = new api();
              $a->studentsApi();
              break;
              case 'add':
              $s = new api();
              $s->addStudentApi();
              break;
              case 'edit':
              $s = new api();
              $s->editStudentApi($route[3]);
              break;
              case 'delete':
              $s = new api();
              $s->deleteStudentApi($route[3]);
              break;
              default:
              $a = new api();
              $a->oneStudentApi($route[2]);
              break;
            }
            break;
          case 'courses':
          switch ($route[2]) {
            case null:
            $a = new api();
            $a->coursesApi();
            break;
            case 'add':
            $s = new api();
            $s->addCourseApi();
            break;
            case 'edit':
            $s = new api();
            $s->editCourseApi($route[3]);
            break;
            case 'delete':
            $s = new api();
            $s->deleteCourseApi($route[3]);
            break;
            default:
            $a = new api();
            $a->oneCourseApi($route[2]);
            break;
          }
          break;
          case 'admins':
          switch ($route[2]) {
            case null:
            $a = new api();
            $a->adminsApi();
            break;
            case 'add':
            $s = new api();
            $s->addAdminApi();
            break;
            case 'edit':
            $s = new api();
            $s->editAdminApi($route[3]);
            break;
            case 'delete':
            $s = new api();
            $s->deleteAdminApi($route[3]);
            break;
            default:
            $a = new api();
            $a->oneAdminApi($route[2]);
            break;
          }
        }
      break;
      case 'logout':
      session::logout();
      header("location: ./");
      break;
      default:
      $s = new School();
      $s->main();
    }
}
// if a person is logged he will be thrown into the login school page
  else {
    if (isset($_SESSION['logged'])) {
      header("location: ./school");
    }
    $s = new School();
    $s->main();
  }