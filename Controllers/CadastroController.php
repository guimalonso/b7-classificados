<?php

namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class CadastroController extends Controller
{
  public function index()
  {
    $this->generateCsrf();
    $this->loadTemplate('cadastro');
  }

  public function cadastrar()
  {
    $dados = array();
    $valido = false;
    $sucesso = false;

    $u = new Usuarios();

    if ($this->verifyCsrf() && isset($_POST['nome']) && !empty($_POST['nome'])) {
      $nome = addslashes($_POST['nome']);
      $email = addslashes($_POST['email']);
      $senha = $_POST['senha'];
      $telefone = addslashes($_POST['telefone']);

      if (!empty($nome) && !empty($email) && !empty($senha)) {
        $valido = true;
        if ($u->cadastrar($nome, $email, $senha, $telefone)) {
          $sucesso = true;
        }
      }
    }

    $dados['valido'] = $valido;
    $dados['sucesso'] = $sucesso;
    $this->generateCsrf();
    $this->loadTemplate('cadastro', $dados);
  }
}
