<div class="container">
  <h1>Meus Anúncios</h1>

  <a href="<?= BASE_URL ?>anuncios/adicionar" class="btn btn-default">Adicionar Anúncio</a>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Foto</th>
        <th>Título</th>
        <th>Valor</th>
        <th>Ações</th>
      </tr>
    </thead>
    <?php foreach ($anuncios as $anuncio) : ?>
      <tr>
        <td>
          <?php if (!empty($anuncio['url'])) : ?>
            <img src="<?= BASE_URL ?>assets/images/anuncios/<?= $anuncio['url'] ?>" height="50">
          <?php else : ?>
            <img src="<?= BASE_URL ?>assets/images/default.png" height="50">
          <?php endif; ?>
        </td>
        <td><?= $anuncio['titulo'] ?></td>
        <td>R$ <?= number_format($anuncio['valor'], 2, ',', '') ?></td>
        <td>
          <a href="<?= BASE_URL ?>anuncios/editar/<?= $anuncio['id'] ?>" class="btn btn-default">Editar</a>
          <a href="javascript:;" onclick="confirmarExclusaoAnuncio(<?= $anuncio['id'] ?>)" id="btn-excluir" class="btn btn-danger">
            Excluir
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <form action="<?= BASE_URL ?>anuncios/excluir" id="form_excluir" method="post">
    <input type="hidden" name="id" id="id" value="">
  </form>
</div>