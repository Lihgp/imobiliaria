function carregar(proprietario) {
  let propId = document.getElementById("proprietario");
  for (let index = 0; index < proprietario.length; index++) {
    option = new Option(
      proprietario[index].nome + " - " + proprietario[index].cpf,
      proprietario[index].codCliente
    );
    propId.options[propId.options.length] = option;
  }
}

function buscarProprietarios() {
  debugger;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function(e) {
    if (xmlhttp.status == 200) {
      if (xmlhttp.responseText != "") {
        try {
          proprietario = JSON.parse(xmlhttp.responseText);
          carregar(proprietario);
        } catch (e) {
          alert(
            "A string retornada pelo servidor não é um JSON válido: " +
              xmlhttp.responseText
          );
        }
      } else alert("Nenhum resultado encontrado.");
    }
  };

  xmlhttp.open("GET", "../../server/buscaProprietario.php", true);
  xmlhttp.send();
}
