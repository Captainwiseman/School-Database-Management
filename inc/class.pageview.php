<?php

class PageView extends View {
  private $component = NULL;
  private $data = NULL;
  // navigation bar buttons visibility
  private $nav =[
    "school"=> false,
    "admin" => false,
    "active" => [
      "school" => "",
      "admin" => ""
    ]
  ];
  // php side error handling
  private $error =[
    "visible" => "hidden",
    "string" => ""
  ];

  function __construct($title=NULL) {
    parent::__construct($title);
  }

  function setComponent($component,$data=NULL) {
    $this->component = $component;
    if($data) {
      $this->data = $data;
    }
  }
  function setNav($school=false,$admin=false) {
    $this->nav =[
      "school"=> $school,
      "admin" => $admin,
      "active" => [
        "school" => "",
        "admin" => ""
      ]
    ];
  }
  function setActive($active) {
    if ($active=="school") {
      $this->nav['active'] =[
          "school" => "active",
          "admin" => ""
      ];
    }
    else if ($active=="admin") {
      $this->nav['active'] =[
        "school" => "",
        "admin" => "active"
    ];
    }
  }
  function dump() {
    require "comp/header.php";
    require 'comp/'.$this->component;
    require "comp/footer.php";
  }
  function dumpCtr() {
    require "comp/headerNavLess.php";
    require 'comp/'.$this->component;
    require "comp/footer.php";
  }
  function setError($error = null) {
    if ($error) {
      $this->error =[
        "visible" => "",
        "string" => $error
      ];
    }
  }
}

