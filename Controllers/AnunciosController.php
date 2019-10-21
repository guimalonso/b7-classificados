<?php

namespace Controllers;

use \Core\Controller;
use \Models\Anuncios;
use \Models\Categorias;

class AnunciosController extends Controller
{
  public function index()
  {
    $this->isUserLogged();

    $a = new Anuncios();

    $dados = array();

    $anuncios = $a->getMeusAnuncios();

    $dados['anuncios'] = $anuncios;

    $this->loadTemplate('anuncios', $dados);
  }

  public function adicionar()
  {
    $this->isUserLogged();
    $this->generateCsrf();

    $dados = array();

    $c = new Categorias();
    $cats = $c->getLista();

    $dados['cats'] = $cats;

    $this->loadTemplate('adicionar-anuncio', $dados);
  }

  public function salvarAdicao()
  {
    $dados = array();
    $sucesso = false;
    $a = new Anuncios();

    if ($this->verifyCsrf() && isset($_POST['titulo']) && !empty($_POST['titulo'])) {
      $titulo = addslashes($_POST['titulo']);
      $categoria = addslashes($_POST['categoria']);
      $valor = addslashes($_POST['valor']);
      $descricao = addslashes($_POST['descricao']);
      $estado = addslashes($_POST['estado']);

      $a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);
      $sucesso = true;
    }

    $dados['sucesso'] = $sucesso;
    $this->generateCsrf();
    $this->loadTemplate('adicionar-anuncio', $dados);
  }

  public function editar($id)
  {
    $this->isUserLogged();
    $this->generateCsrf();

    $dados = array();

    $a = new Anuncios();
    $c = new Categorias();

    $cats = $c->getLista();
    $info = $a->getAnuncio($id);

    $dados['cats'] = $cats;
    $dados['info'] = $info;
    $dados['id'] = $id;

    $this->loadTemplate('editar-anuncio', $dados);
  }

  public function salvarEdicao($id)
  {
    $a = new Anuncios();
    if ($this->verifyCsrf() && isset($_POST['titulo']) && !empty($_POST['titulo'])) {
      $titulo = addslashes($_POST['titulo']);
      $categoria = addslashes($_POST['categoria']);
      $valor = addslashes($_POST['valor']);
      $descricao = addslashes($_POST['descricao']);
      $estado = addslashes($_POST['estado']);
      $fotos = $_FILES['fotos'] ?? array();

      $a->editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id);
    }

    header('Location: ' . BASE_URL . 'anuncios');
    exit();
  }

  public function excluir()
  {
    $this->isUserLogged();

    $a = new Anuncios();

    $id = addslashes($_POST['id']);

    if (!empty($id)) {
      $a->excluirAnuncio($id);
    }

    header('Location: ' . BASE_URL . 'anuncios');
    exit();
  }

  public function excluirFoto()
  {
    $this->isUserLogged();

    $a = new Anuncios();

    $id = addslashes($_POST['id_foto']);

    if (!empty($id)) {
      $id_anuncio = $a->excluirFoto($id);
    }

    $url_redir = BASE_URL . 'anuncios';
    if (isset($id_anuncio)) {
      $url_redir .= '/editar/' . $id_anuncio;
    }

    header('Location: ' . $url_redir);
    exit();
  }
}
