<?php

namespace Core;

class Controller
{
  protected function isUserLogged()
  {
    if (empty($_SESSION['cLogin'])) {
      header('Location: ' . BASE_URL . 'login');
      exit;
    }
  }

  protected function loadView($viewName, $viewData = array())
  {
    extract($viewData);
    require 'Views/' . $viewName . '.php';
  }

  protected function loadTemplate($viewName, $viewData = array())
  {
    require 'Views/template.php';
  }

  protected function loadViewInTemplate($viewName, $viewData = array())
  {
    extract($viewData);
    require 'Views/' . $viewName . '.php';
  }
}
