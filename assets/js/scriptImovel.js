function cadastrarImovel() {
  var formImovel = document.getElementById("formImovel");
  var formData = new FormData(formImovel);

  $.ajax({
    url: "../../server/cadastroImovel.php",
    method: "POST",
    data: formData,
    cache: false,
    processData: false,
    contentType: false,

    success: function(result) {
      if (result.substring(0, 2) == "OK") {
        alert("Imóvel cadastrado com sucesso!");
        document.getElementById("formImovel").reset();
      } else {
        alert(result);
      }
    },
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    }
  });
}

$(".uploadClassificado").change(function() {
  var files = this.files; // SELECIONA OS ARQUIVOS
  var qtde = files.length; // CONTA QUANTOS TEM

  if (qtde > 5) {
    // VERIFICA SE É MAIOR DO QUE 5
    alert("Não é permitido enviar mais do que 5 arquivos.");
    $(this).val("");
    return false;
  } else {
    // SE NÃO FOR MAIS DO QUE 5 ELE CONTINUA.
    return true;
  }
});
