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

// Verificar quantidade de arquivos selecionados
$("#imagensImovel").change(function() {
  debugger;
  var files = this.files; // Seleciona os arquivos
  var qtde = files.length; // Conta quantos arquivos tem

  if (qtde > 6) {
    // Verifica se é maior do que 6
    alert("Não é permitido enviar mais do que 6 arquivos.");
    $(this).val("");
    return false;
  } else {
    // Se não for maior do que 6 continua
    return true;
  }
});

// Função para alterar os campos do formulário ao selecionar CASA ou APARTAMENTO no cadastro de imóveis
$("#categoriaImovel").change(function() {
  debugger;
  let tipoImovel = document.getElementById("categoriaImovel").value;
  if (tipoImovel === "") {
    $("#formCasa").css("display", "none");
    $("#formApartamento").css("display", "none");
  } else if (tipoImovel === "apartamento") {
    $("#formCasa").css("display", "none");
    $("#formApartamento").css("display", "inline");
  } else if (tipoImovel === "casa") {
    $("#formCasa").css("display", "inline");
    $("#formApartamento").css("display", "none");
  }

  // Caso o usuário mude a Categoria do imóvel, os arquivos selecionados serão apagados
  var files = document.getElementById("imagensImovel").files;
  if (files.length > 0) document.getElementById("imagensImovel").value = "";
});
