function confirmarExclusaoAnuncio(id) {
  if (confirm("Deseja mesmo excluir este anúncio?")) {
    window.location = "excluir-anuncio.php?id=" + id;
  }
}

function confirmarExclusaoFoto(id) {
  if (confirm("Deseja mesmo excluir esta foto?")) {
    window.location = "excluir-foto.php?id=" + id;
  }
}
