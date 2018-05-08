<?php

abstract class View {

  protected $title = "FlotsiTime University";
  protected $css = ['handlers/main.css'];
  protected $js = [];


  function __construct($title=NULL) {
    if($title) {
      $this->title = $title;
    }
  }

  function addJs($fileName) {
    $this->js[] = "handlers/{$fileName}";
  }

  function addCss($fileName) {
    $this->css[] = "handlers/{$fileName}";
  }

  abstract function dump();

}


