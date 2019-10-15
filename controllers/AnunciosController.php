<?php

class AnunciosController extends Controller
{
  public function index()
  {
    $this->isUserLogged();

    $a = new Anuncios();
    $this->mostrarAnunciosUsuario($a);
  }

  public function adicionar()
  {
    $this->isUserLogged();

    $dados = array();

    $c = new Categorias();
    $cats = $c->getLista();

    $dados['cats'] = $cats;

    $this->loadTemplate('adicionar-anuncio', $dados);
  }

  public function incluir()
  {
    $dados = array();
    $sucesso = false;
    $a = new Anuncios();

    if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
      $titulo = addslashes($_POST['titulo']);
      $categoria = addslashes($_POST['categoria']);
      $valor = addslashes($_POST['valor']);
      $descricao = addslashes($_POST['descricao']);
      $estado = addslashes($_POST['estado']);

      $a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);
      $sucesso = true;
    }

    $dados['sucesso'] = $sucesso;
    $this->loadTemplate('adicionar-anuncio', $dados);
  }

  public function editar($id)
  {
    $this->isUserLogged();

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

  public function atualizar($id)
  {
    $a = new Anuncios();
    if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
      $titulo = addslashes($_POST['titulo']);
      $categoria = addslashes($_POST['categoria']);
      $valor = addslashes($_POST['valor']);
      $descricao = addslashes($_POST['descricao']);
      $estado = addslashes($_POST['estado']);
      $fotos = $_FILES['fotos'] ?? array();

      $a->editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id);
    }

    $this->mostrarAnunciosUsuario($a);
  }

  public function excluir()
  {
    $this->isUserLogged();

    $a = new Anuncios();

    $id = addslashes($_POST['id']);

    if (!empty($id)) {
      $a->excluirAnuncio($id);
    }

    $this->mostrarAnunciosUsuario($a);
  }

  public function excluir_foto()
  {
    $this->isUserLogged();

    $a = new Anuncios();

    $id = addslashes($_POST['id_foto']);

    if (!empty($id)) {
      $id_anuncio = $a->excluirFoto($id);
    }

    if (isset($id_anuncio)) {
      $this->editar($id_anuncio);
    } else {
      $this->mostrarAnunciosUsuario($a);
    }
  }

  private function mostrarAnunciosUsuario($objAnuncios)
  {
    $dados = array();

    $anuncios = $objAnuncios->getMeusAnuncios();

    $dados['anuncios'] = $anuncios;

    $this->loadTemplate('anuncios', $dados);
  }
}
