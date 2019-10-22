<?php

namespace Models;

use \Core\Model;

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

  public static function getMaxCategoria()
  {
    global $db;
    $sql = $db->query("SELECT MAX(id) AS max_id FROM categorias");
    $row = $sql->fetch();
    return $row['max_id'];
  }
}
