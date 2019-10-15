function confirmarExclusaoAnuncio(id) {
  if (confirm("Deseja mesmo excluir este anúncio?")) {
    document.getElementById("id").value = id;
    document.getElementById("form_excluir").submit();
  }
}

function confirmarExclusaoFoto(id) {
  if (confirm("Deseja mesmo excluir esta foto?")) {
    document.getElementById("id_foto").value = id;
    document.getElementById("form_excluir_foto").submit();
  }
}
