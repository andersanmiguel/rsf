<?php

class Mapper extends Controller {

  function __call($view, $data) {

    $this->load->setTemplate('index');

    if ($view == 'index') {
      $this->load->view($this->controller);
    } else {
      $this->load->view($this->controller.'/'.$this->view);
    }

  }

}
