<?php

class Categorias extends Model
{
  public function getLista()
  {
    $sql = $this->db->query("SELECT * FROM categorias");

    $categorias = array();
    if ($sql->rowCount() > 0) {
      $categorias = $sql->fetchAll();
    }

    return $categorias;
  }
}
