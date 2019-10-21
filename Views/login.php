<div class="container">
  <h1>Login</h1>
  <?php if (isset($erro_csrf)) : ?>
    <div class="alert alert-danger">
      Ação não permitida!
    </div>
  <?php endif; ?>
  <?php if (isset($falha)) : ?>
    <div class="alert alert-danger">
      Usuário e/ou senha inválidos!
    </div>
  <?php endif; ?>
  <form method="post" action="<?= BASE_URL ?>login/login">

    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>

    <div class="form-group">
      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" class="form-control">
    </div>

    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

    <input type="submit" value="Fazer Login" class="btn btn-default">
  </form>
</div>