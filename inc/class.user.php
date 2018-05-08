<?php
  class user {

    //Process Login 
    function dologin($login) {
      $users = new usermodel();
      $ret = $users->getUserByMail($login);
      $hash_check = $users->pwhash_test($_POST['password'],$ret['hash']);
      if ($hash_check) {
        Session::setLogged($ret);
        return true;
      }
      else {
        return false;
      }

    }
    //Logout
    function logout() {
      Session::logout();
    }
  }