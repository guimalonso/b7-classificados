<?php

namespace Controllers;

use \Core\Controller;
use \Models\Anuncios;

class ProdutoController extends Controller
{
  public function index()
  { }

  public function abrir($id)
  {
    if (empty($id)) {
      header("Location: " . BASE_URL);
      exit;
    }

    $dados = array();

    $a = new Anuncios();

    $info = $a->getAnuncio($id);
    $dados['info'] = $info;

    $this->loadTemplate('produto', $dados);
  }
}
