<?php

class LoginController extends Controller
{
  public function index()
  {
    $this->loadTemplate('login');
  }

  public function login()
  {
    $u = new Usuarios();

    if (isset($_POST['email']) && !empty($_POST['email'])) {
      $email = addslashes($_POST['email']);
      $senha = $_POST['senha'];

      if ($u->login($email, $senha)) {
        header('Location: ' . BASE_URL);
        exit;
      }
    }

    $dados = array();
    $dados['falha'] = true;

    $this->loadTemplate('login', $dados);
  }

  public function sair()
  {
    unset($_SESSION['cLogin']);
    header("Location: " . BASE_URL);
    exit;
  }
}
