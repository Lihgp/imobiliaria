$("#cep").change(function() {
  debugger;
  var cep = document.getElementById("cep").value;
  if (cep.length === 9) buscaEndereco(cep);
  else {
    // Caso já tenha sido carregado o endereço e a pessoa trocou o CEP
    var logradouro = document.getElementById("logradouro").value;
    var estado = document.getElementById("estado").value;
    var bairro = document.getElementById("bairro").value;
    var cidade = document.getElementById("cidade").value;
    if (logradouro !== null || logradouro !== undefined || logradouro !== "")
      document.getElementById("logradouro").value = "";
    if (estado !== null || estado !== undefined || estado !== "")
      document.getElementById("estado").value = "";
    if (bairro !== null || bairro !== undefined || bairro !== "")
      document.getElementById("bairro").value = "";
    if (cidade !== null || cidade !== undefined || cidade !== "")
      document.getElementById("cidade").value = "";
  }
});

function carregar(cep) {
  debugger;
  //   document.getElementById("tabela-funcionario").innerHTML = "";

  document.getElementById("logradouro").value = cep.logradouro;
  document.getElementById("estado").value = cep.estado;
  document.getElementById("bairro").value = cep.bairro;
  document.getElementById("cidade").value = cep.cidade;
}

function buscaEndereco(cep) {
  debugger;
  if (cep.length !== 9 || cep === "" || cep === undefined || cep === null) {
    return;
  }
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function(e) {
    if (xmlhttp.status == 200) {
      if (xmlhttp.responseText != "") {
        try {
          debugger;
          cep = JSON.parse(xmlhttp.responseText);
          carregar(cep);
        } catch (e) {
          debugger;
          alert(
            "A string retornada pelo servidor não é um JSON válido: " +
              xmlhttp.responseText
          );
        }
      }
    }
  };

  var filtro = "?cep=".concat(cep);

  xmlhttp.open("GET", "../../server/buscaEndereco.php" + filtro, true);
  xmlhttp.send();
}
