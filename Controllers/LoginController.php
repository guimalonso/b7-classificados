<?php

namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class LoginController extends Controller
{
  public function index()
  {
    $this->generateCsrf();
    $this->loadTemplate('login');
  }

  public function login()
  {
    $u = new Usuarios();
    $dados = array();

    if (!$this->verifyCsrf()) {
      $dados['erro_csrf'] = true;
    } else if (isset($_POST['email']) && !empty($_POST['email'])) {
      $email = addslashes($_POST['email']);
      $senha = $_POST['senha'];

      if ($u->login($email, $senha)) {
        header('Location: ' . BASE_URL);
        exit;
      } else {
        $dados['falha'] = true;
      }
    }

    $this->loadTemplate('login', $dados);
  }

  public function sair()
  {
    unset($_SESSION['cLogin']);
    header("Location: " . BASE_URL);
    exit;
  }
}
