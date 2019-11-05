function carregar(cliente) {
  // Limpa o Tbody para evitar duplicação
  document.getElementById("tabela-cliente").innerHTML = "";
  debugger;
  for (let index = 0; index < cliente.length; index++) {
    var newRow = document.createElement("tr");
    newRow.insertCell(0).innerHTML = cliente[index].codCliente;
    newRow.insertCell(1).innerHTML = cliente[index].nome;
    newRow.insertCell(2).innerHTML = cliente[index].cpf;
    newRow.insertCell(3).innerHTML = cliente[index].telefoneCelular;
    if (cliente[index].sexo === "m")
      newRow.insertCell(4).innerHTML = "Masculino";
    else if (cliente[index].sexo === "f")
      newRow.insertCell(4).innerHTML = "Feminino";

    document.getElementById("tabela-cliente").appendChild(newRow);
  }
}

function buscaCliente(nome, cpf, telefoneCelular, sexo) {
  debugger;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function(e) {
    if (xmlhttp.status == 200) {
      if (xmlhttp.responseText != "") {
        try {
          debugger;
          cliente = JSON.parse(xmlhttp.responseText);
          carregar(cliente);
        } catch (e) {
          debugger;
          alert(
            "A string retornada pelo servidor não é um JSON válido: " +
              xmlhttp.responseText
          );
        }
      } else alert("Nenhum resultado encontrado.");
    }
  };
  var arquivo = "../../server/buscaCliente.php";
  if (nome === undefined || nome === "") nome = "";
  if (cpf === undefined || cpf === "") cpf = "";
  if (sexo === undefined || sexo === "") sexo = "Todos";
  if (telefoneCelular === undefined || telefoneCelular === "")
    telefoneCelular = "";

  var filtro = "?nome="
    .concat(nome)
    .concat("&cpf=")
    .concat(cpf)
    .concat("&telefoneCelular=")
    .concat(telefoneCelular)
    .concat("&sexo=")
    .concat(sexo);

  xmlhttp.open("GET", arquivo + filtro, true);
  xmlhttp.send();
}
