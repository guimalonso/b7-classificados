<?php require 'pages/header.php'; ?>
<?php
if (empty($_SESSION['cLogin'])) {
  ?>
  <script type="text/javascript">
    window.location = "login.php";
  </script>
<?php
  exit;
}

require 'classes/anuncios.class.php';
$a = new Anuncios();
if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
  $titulo = addslashes($_POST['titulo']);
  $categoria = addslashes($_POST['categoria']);
  $valor = addslashes($_POST['valor']);
  $descricao = addslashes($_POST['descricao']);
  $estado = addslashes($_POST['estado']);
  $fotos = $_FILES['fotos'] ?? array();

  $a->editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $_GET['id']);

  ?>
  <div class="alert alert-success">
    Produto editado com sucesso!
  </div>
<?php
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $info = $a->getAnuncio($_GET['id']);
} else {
  ?>
  <script type="text/javascript">
    window.location = "meus-anuncios.php";
  </script>
<?php
  exit;
}

?>
<div class="container">
  <h1>Adicionar Anúncio</h1>

  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="categoria">Categoria:</label>
      <select name="categoria" id="categoria" class="form-control">
        <?php
        require 'classes/categorias.class.php';
        $c = new Categorias();
        $cats = $c->getLista();
        foreach ($cats as $cat) :
          ?>
          <option value="<?= $cat['id'] ?>" <?php echo ($info['id_categoria'] == $cat['id']) ? 'selected' : '' ?>>
            <?= utf8_encode($cat['nome']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" value="<?= $info['titulo'] ?>" class="form-control">
    </div>

    <div class="form-group">
      <label for="valor">Valor:</label>
      <input type="text" name="valor" id="valor" value="<?= $info['valor'] ?>" class="form-control">
    </div>

    <div class="form-group">
      <label for="descricao">Descrição:</label>
      <textarea name="descricao" id="descricao" class="form-control"><?= $info['descricao'] ?></textarea>
    </div>

    <div class="form-group">
      <label for="estado">Estado de Conservação:</label>
      <select name="estado" id="estado" class="form-control">
        <option value="0" <?php echo ($info['estado'] == 0) ? 'selected' : '' ?>>Ruim</option>
        <option value="1" <?php echo ($info['estado'] == 1) ? 'selected' : '' ?>>Bom</option>
        <option value="2" <?php echo ($info['estado'] == 2) ? 'selected' : '' ?>>Ótimo</option>
      </select>
    </div>

    <div class="form-group">
      <label for="add_foto">Fotos do anúncio</label>
      <input type="file" name="fotos[]" multiple>

      <div class="panel panel-default">
        <div class="panel-heading">Fotos do anúncio</div>
        <div class="panel-body">
          <?php foreach ($info['fotos'] as $foto) : ?>
            <div class="foto_item">
              <img src="assets/images/anuncios/<?= $foto['url'] ?>" class="img-thumbnail"><br>
              <a href="javascript:;" onclick="confirmarExclusaoFoto(<?= $foto['id'] ?>)" class="btn btn-default">
                Excluir Imagem
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <input type="submit" value="Salvar" class="btn btn-default">
  </form>
</div>
<?php require 'pages/footer.php'; ?>