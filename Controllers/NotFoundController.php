<?php

namespace Controllers;

use \Core\Controller;

class NotFoundController extends Controller
{
  public function index()
  {
    $this->loadTemplate('404', array());
  }
}
