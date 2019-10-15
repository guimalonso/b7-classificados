<?php

class Controller
{
  protected function isUserLogged()
  {
    if (empty($_SESSION['cLogin'])) {
      header('Loaction: ' . BASE_URL . 'login');
      exit;
    }
  }

  protected function loadView($viewName, $viewData = array())
  {
    extract($viewData);
    require 'views/' . $viewName . '.php';
  }

  protected function loadTemplate($viewName, $viewData = array())
  {
    require 'views/template.php';
  }

  protected function loadViewInTemplate($viewName, $viewData = array())
  {
    extract($viewData);
    require 'views/' . $viewName . '.php';
  }
}
