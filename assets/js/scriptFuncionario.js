function carregar(funcionario) {
  debugger;
  // Limpa o Tbody para evitar duplicação
  document.getElementById("tabela-funcionario").innerHTML = "";

  for (let index = 0; index < funcionario.length; index++) {
    var newRow = document.createElement("tr");
    newRow.insertCell(0).innerHTML = funcionario[index].codFuncionario;
    newRow.insertCell(1).innerHTML = funcionario[index].nome;
    newRow.insertCell(2).innerHTML = funcionario[index].telefone;
    newRow.insertCell(3).innerHTML = funcionario[index].cpf;
    newRow.insertCell(4).innerHTML = funcionario[index].cargo;
    newRow.insertCell(5).innerHTML = funcionario[index].telefoneCelular;
    document.getElementById("tabela-funcionario").appendChild(newRow);
  }
}

function buscaFuncionario(nome, cpf, telefone, cargo, telefoneCelular) {
  debugger;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function(e) {
    if (xmlhttp.status == 200) {
      if (xmlhttp.responseText != "") {
        try {
          debugger;
          funcionario = JSON.parse(xmlhttp.responseText);
          carregar(funcionario);
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
  var arquivo = "../../server/buscaFuncionario.php";
  if (nome === undefined || nome === "") nome = "";
  if (cpf === undefined || cpf === "") cpf = "";
  if (cargo === undefined || cargo === "") cargo = "Todos";
  if (telefone === undefined || telefone === "") telefone = "";
  if (telefoneCelular === undefined || telefoneCelular === "")
    telefoneCelular = "";

  var filtro = "?nome="
    .concat(nome)
    .concat("&cpf=")
    .concat(cpf)
    .concat("&telefone=")
    .concat(telefone)
    .concat("&cargo=")
    .concat(cargo)
    .concat("&telefoneCelular=")
    .concat(telefoneCelular);

  xmlhttp.open("GET", arquivo + filtro, true);
  xmlhttp.send();
}
