<?php

namespace Models;

use \Core\Model;

class Anuncios extends Model
{
  public function getTotalAnuncios($filtros)
  {
    $filtrostring = array('1=1');
    if (!empty($filtros['categoria'])) {
      $filtrostring[] = 'id_categoria = :id_categoria';
    }

    if (!empty($filtros['preco'])) {
      $filtrostring[] = 'valor BETWEEN :preco1 AND :preco2';
    }

    if (!empty($filtros['estado'])) {
      $filtrostring[] = 'estado = :estado';
    }

    $sql = $this->db->prepare("SELECT COUNT(*) AS c FROM anuncios
                          WHERE " . implode(' AND ', $filtrostring));

    if (!empty($filtros['categoria'])) {
      $sql->bindValue(':id_categoria', $filtros['categoria']);
    }

    if (!empty($filtros['preco'])) {
      $precos = explode('-', $filtros['preco']);
      $sql->bindValue(':preco1', $precos[0]);
      $sql->bindValue(':preco2', $precos[1]);
    }

    if (!empty($filtros['estado'])) {
      $sql->bindValue(':estado', $filtros['estado']);
    }

    $sql->execute();
    $row = $sql->fetch();

    return $row['c'];
  }

  public function getUltimosAnuncios($page, $perPage, $filtros)
  {
    $offset = ($page - 1) * $perPage;

    $filtrostring = array('1=1');
    if (!empty($filtros['categoria'])) {
      $filtrostring[] = 'a.id_categoria = :id_categoria';
    }

    if (!empty($filtros['preco'])) {
      $filtrostring[] = 'a.valor BETWEEN :preco1 AND :preco2';
    }

    if (!empty($filtros['estado'])) {
      $filtrostring[] = 'a.estado = :estado';
    }

    $sql = $this->db->prepare("SELECT a.*, i.url, c.nome AS categoria FROM anuncios a
                        LEFT JOIN anuncios_imagens i ON i.id_anuncio = a.id
                        LEFT JOIN categorias c ON a.id_categoria = c.id
                        WHERE " . implode(' AND ', $filtrostring) . "
                        GROUP BY a.id ORDER BY a.id DESC LIMIT $offset, 2");

    if (!empty($filtros['categoria'])) {
      $sql->bindValue(':id_categoria', $filtros['categoria']);
    }

    if (!empty($filtros['preco'])) {
      $precos = explode('-', $filtros['preco']);
      $sql->bindValue(':preco1', $precos[0]);
      $sql->bindValue(':preco2', $precos[1]);
    }

    if (!empty($filtros['estado'])) {
      $sql->bindValue(':estado', $filtros['estado']);
    }

    $sql->execute();

    $array = array();
    if ($sql->rowCount() > 0) {
      $array = $sql->fetchAll();
    }

    return $array;
  }

  public function getMeusAnuncios()
  {
    $sql = $this->db->prepare("SELECT a.*, i.url FROM anuncios a
                        LEFT JOIN anuncios_imagens i ON i.id_anuncio = a.id
                        WHERE a.id_usuario = :id_usuario
                        GROUP BY a.id");
    $sql->bindValue(":id_usuario", $_SESSION['cLogin']['id']);
    $sql->execute();

    $array = array();
    if ($sql->rowCount() > 0) {
      $array = $sql->fetchAll();
    }

    return $array;
  }

  public function getAnuncio($id)
  {
    $array = array();
    $sql = $this->db->prepare("SELECT a.*, c.nome AS categoria, u.telefone FROM anuncios a
                          JOIN categorias c ON a.id_categoria = c.id
                          JOIN usuarios u ON a.id_usuario = u.id
                          WHERE a.id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if ($sql->rowCount() == 1) {
      $array = $sql->fetch();
      $array['fotos'] = array();

      $sql = $this->db->prepare("SELECT id, url FROM anuncios_imagens WHERE
        id_anuncio = :id_anuncio");
      $sql->bindValue(":id_anuncio", $id);
      $sql->execute();

      if ($sql->rowCount() > 0) {
        $array['fotos'] = $sql->fetchAll();
      }
    }

    return $array;
  }

  public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado)
  {
    $sql = $this->db->prepare("INSERT INTO anuncios SET titulo = :titulo,
      id_categoria = :id_categoria, id_usuario = :id_usuario, descricao = :descricao,
      valor = :valor, estado = :estado");
    $sql->bindvalue(":titulo", $titulo);
    $sql->bindValue(":id_categoria", $categoria);
    $sql->bindValue(":id_usuario", $_SESSION['cLogin']['id']);
    $sql->bindValue(":descricao", $descricao);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":estado", $estado);
    $sql->execute();
  }

  public function editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id)
  {
    $sql = $this->db->prepare("UPDATE anuncios SET titulo = :titulo,
      id_categoria = :id_categoria, descricao = :descricao,
      valor = :valor, estado = :estado WHERE id = :id");
    $sql->bindvalue(":titulo", $titulo);
    $sql->bindValue(":id_categoria", $categoria);
    $sql->bindValue(":descricao", $descricao);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":estado", $estado);
    $sql->bindValue(":id", $id);
    $sql->execute();

    if (count($fotos) > 0) {
      for ($q = 0; $q < count($fotos['tmp_name']); $q++) {
        $tipo = $fotos['type'][$q];
        if (in_array($tipo, array('image/jpeg', 'image/png'))) {
          $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
          $filepath = 'assets/images/anuncios/' . $tmpname;
          move_uploaded_file($fotos['tmp_name'][$q], $filepath);

          list($width_orig, $height_orig) = getimagesize($filepath);
          $ratio = $width_orig / $height_orig;

          $width = 500;
          $height = 500;

          if ($width / $height > $ratio) {
            $width = $height * $ratio;
          } else {
            $height = $width / $ratio;
          }

          $img = imagecreatetruecolor($width, $height);
          if ($tipo == 'image/jpeg') {
            $orig = imagecreatefromjpeg($filepath);
          } else {
            $orig = imagecreatefrompng($filepath);
          }

          imagecopyresampled(
            $img,
            $orig,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $width_orig,
            $height_orig
          );

          imagejpeg($img, $filepath, 80);

          $sql = $this->db->prepare("INSERT INTO anuncios_imagens SET
            id_anuncio = :id_anuncio,
            url = :url");
          $sql->bindValue(":id_anuncio", $id);
          $sql->bindValue(":url", $tmpname);
          $sql->execute();
        }
      }
    }
  }

  public function excluirAnuncio($id)
  {
    $sql = $this->db->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
    $sql->bindValue(":id_anuncio", $id);
    $sql->execute();

    $sql = $this->db->prepare("DELETE FROM anuncios WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
  }

  public function excluirFoto($id)
  {
    $id_anuncio = 0;

    $sql = $this->db->prepare("SELECT id_anuncio, url FROM anuncios_imagens WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if ($sql->rowCount() > 0) {
      $row = $sql->fetch();
      $id_anuncio = $row['id_anuncio'];
    }

    $sql = $this->db->prepare("DELETE FROM anuncios_imagens WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    unlink('assets/images/anuncios/' . $row['url']);

    return $id_anuncio;
  }
}
