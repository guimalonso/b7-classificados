<div class="container">
  <h1>Adicionar Anúncio</h1>

  <?php if (isset($sucesso) && $sucesso) : ?>
    <div class="alert alert-success">
      Produto adicionado com sucesso!
    </div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>anuncios/salvarAdicao" enctype="multipart/form-data">
    <div class="form-group">
      <label for="categoria">Categoria:</label>
      <select name="categoria" id="categoria" class="form-control">
        <?php foreach ($cats as $cat) : ?>
          <option value="<?= $cat['id'] ?>"><?= utf8_encode($cat['nome']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" class="form-control">
    </div>

    <div class="form-group">
      <label for="valor">Valor:</label>
      <input type="number" name="valor" id="valor" class="form-control">
    </div>

    <div class="form-group">
      <label for="descricao">Descrição:</label>
      <textarea name="descricao" id="descricao" class="form-control"></textarea>
    </div>

    <div class="form-group">
      <label for="estado">Estado de Conservação:</label>
      <select name="estado" id="estado" class="form-control">
        <option value="0">Ruim</option>
        <option value="1">Bom</option>
        <option value="2">Ótimo</option>
      </select>
    </div>

    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <input type="submit" value="Adicionar" class="btn btn-default">
  </form>
</div>