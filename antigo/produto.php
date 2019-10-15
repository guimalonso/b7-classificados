<?php require 'pages/header.php';
require 'classes/anuncios.class.php';
require 'classes/usuarios.class.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = addslashes($_GET['id']);
} else {
  ?>
  <script type="text/javascript">
    window.location = "login.php";
  </script>
<?php
  exit;
}

$a = new Anuncios();
$u = new Usuarios();

$info = $a->getAnuncio($id);

?>

<div class="container-fluid">

  <div class="row">
    <div class="col-sm-5">
      <div class="carousel slide" data-ride="carousel" id="meuCarousel">
        <div class="carousel-inner" role="listbox">
          <?php foreach ($info['fotos'] as $chave => $foto) : ?>
            <div class="item <?php echo ($chave == 0 ? 'active' : '') ?>">
              <img src="assets/images/anuncios/<?= $foto['url'] ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <a href="#meuCarousel" class="left carousel-control" role="button" data-slide="prev"><span>
          <</span> </a> <a href="#meuCarousel" class="right carousel-control" role="button" data-slide="next"><span>></span></a>
    </div>
    <div class="col-sm-7">
      <h1><?= $info['titulo'] ?></h1>
      <h4><?= $info['categoria'] ?></h4>
      <p><?= $info['descricao'] ?></p>
      <br>
      <h3>R$ <?= number_format($info['valor'], 2, ',', '') ?></h3>
      <h4>Telefone: <?= $info['telefone'] ?></h4>
    </div>
  </div>
</div>

<?php require 'pages/footer.php'; ?>