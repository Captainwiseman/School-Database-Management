<?php

class Session {

  static function logged() {
    return (isset($_SESSION['logged'])) ? $_SESSION['logged'] : NULL;
  }

  static function setLogged($u) {
    $_SESSION['logged'] = $u;
  }

  static function logout() {
    session_destroy();
    $_SESSION = NULL;
  }

}