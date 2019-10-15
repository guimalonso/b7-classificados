<?php

class Categorias
{
  public function getLista()
  {
    global $pdo;

    $sql = $pdo->query("SELECT * FROM categorias");

    $categorias = array();
    if ($sql->rowCount() > 0) {
      $categorias = $sql->fetchAll();
    }

    return $categorias;
  }
}
