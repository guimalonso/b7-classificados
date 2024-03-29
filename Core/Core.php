<?php

namespace Core;

class Core
{
  public function run()
  {
    $this->checkSessionOwner();

    $url = '/';
    if (isset($_GET['url'])) {
      $url .= $_GET['url'];
    }

    $url = $this->checkRoutes($url);

    $params = array();

    if (!empty($url) && $url != '/') {
      $url = explode('/', $url);
      array_shift($url);

      $currentController = ucfirst($url[0]) . 'Controller';
      array_shift($url);

      if (isset($url[0]) && !empty($url[0])) {
        $currentAction = $url[0];
        array_shift($url);
      } else {
        $currentAction = 'index';
      }

      if (count($url) > 0) {
        $params = $url;
      }
    } else {
      $currentController = 'HomeController';
      $currentAction = 'index';
    }

    $prefix = '\Controllers\\';

    if (
      !file_exists('Controllers/' . $currentController . '.php')
      || !method_exists($prefix . $currentController, $currentAction)
    ) {
      $currentController = 'NotFoundController';
      $currentAction = "index";
    }

    $newController = $prefix . $currentController;
    $c = new $newController();
    call_user_func_array(array($c, $currentAction), $params);
  }

  private function checkRoutes($url)
  {
    global $routes;

    foreach ($routes as $pt => $newurl) {
      $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $pt);

      if (preg_match('#^(' . $pattern . ')*$#i', $url, $matches) === 1) {
        array_shift($matches);
        array_shift($matches);

        $itens = array();
        if (preg_match_all('(\{[a-z0-9]{1,}\})', $pt, $m)) {
          $itens = preg_replace('(\{|\})', '', $m[0]);
        }

        $arg = array();
        foreach ($matches as $key => $match) {
          $arg[$itens[$key]] = $match;
        }

        foreach ($arg as $argkey => $argvalue) {
          $newurl = str_replace(':' . $argkey, $argvalue, $newurl);
        }

        $url = $newurl;

        break;
      }
    }

    return $url;
  }

  private function checkSessionOwner()
  {
    $owner_id = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    if (!isset($_SESSION['owner'])) {
      $_SESSION['owner'] = $owner_id;
    }

    if ($owner_id != $_SESSION['owner']) {
      die('Acesso não permitido');
    }
  }
}
