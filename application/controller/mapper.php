<?php

class Mapper extends Controller {

  function __construct() {

    parent::__construct();
    $this->load->setTemplate('index');
    $this->load->templateData('header_data', array('title' => 'Portada'));

  }

  function __call($view, $data) {

    if ($view == 'index') {
      $this->load->view($this->controller);
    } else {
      $this->load->view($this->controller.'/'.$this->view);
    }

  }

}
