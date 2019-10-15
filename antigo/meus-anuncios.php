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
?>
<div class="container">
  <h1>Meus Anúncios</h1>

  <a href="add-anuncio.php" class="btn btn-default">Adicionar Anúncio</a>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Foto</th>
        <th>Título</th>
        <th>Valor</th>
        <th>Ações</th>
      </tr>
    </thead>
    <?php
    require 'classes/anuncios.class.php';
    $a = new Anuncios();
    $anuncios = $a->getMeusAnuncios();

    foreach ($anuncios as $anuncio) :
      ?>
      <tr>
        <td>
          <?php if (!empty($anuncio['url'])) : ?>
            <img src="assets/images/anuncios/<?= $anuncio['url'] ?>" height="50">
          <?php else : ?>
            <img src="assets/images/default.png" height="50">
          <?php endif; ?>
        </td>
        <td><?= $anuncio['titulo'] ?></td>
        <td>R$ <?= number_format($anuncio['valor'], 2, ',', '') ?></td>
        <td>
          <a href="editar-anuncio.php?id=<?= $anuncio['id'] ?>" class="btn btn-default">Editar</a>
          <a href="javascript:;" onclick="confirmarExclusaoAnuncio(<?= $anuncio['id'] ?>)" id="btn-excluir" class="btn btn-danger">
            Excluir
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php require 'pages/footer.php'; ?>