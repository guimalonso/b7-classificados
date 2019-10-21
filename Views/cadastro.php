<div class="container">
  <h1>Cadastre-se</h1>
  <?php if (isset($sucesso) && $sucesso) {
    ?>
    <div class="alert alert-success">
      <strong>Parabéns!</strong> Cadastrado com sucesso. <a href="<?= BASE_URL ?>login" class="alert-link">Faça o login agora.</a>
    </div>
  <?php
  } else if (isset($valido) && $valido) {
    ?>
    <div class="alert alert-warning">
      Este usuário já existe!
    </div>
  <?php
  } else if (isset($valido)) {
    ?>
    <div class="alert alert-warning">
      Preencha todos os campos!
    </div>
  <?
  }
  ?>
  <form method="post" action="<?= BASE_URL ?>cadastro/cadastrar">
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" name="nome" id="nome" class="form-control">
    </div>

    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>

    <div class="form-group">
      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" class="form-control">
    </div>

    <div class="form-group">
      <label for="telefone">Telefone:</label>
      <input type="text" name="telefone" id="telefone" class="form-control">
    </div>

    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <input type="submit" value="Cadastrar" class="btn btn-default">
  </form>
</div>