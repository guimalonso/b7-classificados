<?php require 'pages/header.php';
require 'classes/anuncios.class.php';
require 'classes/usuarios.class.php';
require 'classes/categorias.class.php';

$a = new Anuncios();
$u = new Usuarios();
$c = new Categorias();

$filtros = array(
  'categoria' => '',
  'preco' => '',
  'estado' => ''
);
if (isset($_GET['filtros'])) {
  $filtros = $_GET['filtros'];
}

$total_anuncios = $a->getTotalAnuncios($filtros);
$total_usuarios = $u->getTotalUsuarios();

$p = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
  $p = addslashes($_GET['p']);
}
$por_pagina = 2;
$total_paginas = ceil($total_anuncios / 2);

$anuncios = $a->getUltimosAnuncios($p, $por_pagina, $filtros);
$categorias = $c->getLista();
?>

<div class="container-fluid">
  <div class="jumbotron">
    <h2>Nós temos hoje <?= $total_anuncios ?> anúncios.</h2>
    <p>E mais de <?= $total_usuarios ?> usuários cadastrados.</p>
  </div>

  <div class="row">
    <div class="col-sm-3">
      <h4>Pesquisa Avançada</h4>
      <form method="get">
        <div class="form-group">
          <label for="categoria">Categoria:</label>
          <select name="filtros[categoria]" class="form-control">
            <option value=""></option>
            <?php foreach ($categorias as $cat) : ?>
              <option value="<?= $cat['id'] ?>" <?php if ($cat['id'] == $filtros['categoria']) echo 'selected' ?>>
                <?= utf8_encode($cat['nome']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="categoria">Preço:</label>
          <select name="filtros[preco]" class="form-control">
            <option value=""></option>
            <option value="0-50" <?php if ($filtros['preco'] == '0-50') echo 'selected' ?>>R$ 0 - 50</option>
            <option value="51-100" <?php if ($filtros['preco'] == '51-100') echo 'selected' ?>>R$ 51 - 100</option>
            <option value="101-200" <?php if ($filtros['preco'] == '101-200') echo 'selected' ?>>R$ 101 - 200</option>
            <option value="201-500" <?php if ($filtros['preco'] == '201-500') echo 'selected' ?>>R$ 201 - 500</option>
          </select>
        </div>
        <div class="form-group">
          <label for="estado">Estado de Conservação:</label>
          <select name="filtros[estado]" class="form-control">
            <option value=""></option>
            <option value="0" <?php if ($filtros['estado'] == '0') echo 'selected' ?>>Ruim</option>
            <option value="1" <?php if ($filtros['estado'] == '1') echo 'selected' ?>>Bom</option>
            <option value="2" <?php if ($filtros['estado'] == '2') echo 'selected' ?>>Ótimo</option>
          </select>
        </div>

        <div class="form-group">
          <input type="submit" value="Buscar" class="btn btn-info">
        </div>
      </form>
    </div>
    <div class="col-sm-9">
      <h4>Últimos Anúncios</h4>
      <table class="table table-striped">
        <tbody>
          <?php foreach ($anuncios as $anuncio) : ?>
            <tr>
              <td>
                <?php if (!empty($anuncio['url'])) : ?>
                  <img src="assets/images/anuncios/<?= $anuncio['url'] ?>" height="50">
                <?php else : ?>
                  <img src="assets/images/default.png" height="50">
                <?php endif; ?>
              </td>
              <td><a href="produto.php?id=<?= $anuncio['id'] ?>"><?= $anuncio['titulo'] ?></a><br>
                <?= utf8_encode($anuncio['categoria']) ?>
              </td>
              <td>R$ <?= number_format($anuncio['valor'], 2, ',', '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <ul class="pagination">
        <?php for ($q = 1; $q <= $total_paginas; $q++) :
          $w = $_GET;
          $w['p'] = $q;
          $s = http_build_query($w);
          ?>
          <li class="<?php echo ($p == $q ? 'active' : '') ?>"><a href="index.php?<?= $s ?>"><?= $q ?></a></li>
        <?php endfor; ?>
      </ul>
    </div>
  </div>
</div>

<?php require 'pages/footer.php'; ?>