//Função para o botão Login
$(".click-login").click(function() {
  $("#modal-login").modal("show");
});

//Função para remover mensagem de erro do login
function removeMensagemErro() {
  $("#alerta-invalido").css("display", "none");
}

//Função para validar o login
$("#enviar-login").click(function() {
  var usuario = document.getElementById("user").value;
  var senha = document.getElementById("senha").value;

  if (usuario === "admin" && senha === "admin") {
    removeMensagemErro();
    $("#barraNavegacaoPublico").hide();
    $("#barraNavegacaoRestrita").show();
    $("#modal-login").modal("hide");
    //Adicionar um efeito de LOAD
  } else {
    $("#alerta-invalido").fadeIn(200);
    $("#alerta-invalido").css("display", "inline-block");
    $("#alerta-invalido").css("width", "100%");
    $("#alerta-invalido").text("Usuário ou senha incorreto.");
  }
});

// Função para quando clicar no X do modal, sair a mensagem de erro
$(".close").click(removeMensagemErro());

// Função para quando sair do modal sair a mensagem de erro
$("#modal-login").on("hide.bs.modal", removeMensagemErro());

$("#botaoDivPesquisa").click(function() {
  $("#divPesquisa").show();
  $("#divPesquisa2").show();
});

// Máscaras para os campos input
$(document).ready(function() {
  $("#precoMinimo").mask("#.##0,00", { reverse: true });
  $("#precoMaximo").mask("#.##0,00", { reverse: true });
  $("#cep").mask("00000-000");
  $("#numero").mask("#");
  $("#cpf").mask("000.000.000-00");
  $("#celular").mask("#0000-0000", { reverse: true });
  $("#telefone").mask("#0000-0000", { reverse: true });
  $("#outroTelefone").mask("#0000-0000", { reverse: true });
  $("#estado").mask("AA");
  $("#dataIngresso").mask("00/00/0000");
  $("#salario").mask("#.##0,00", { reverse: true });
});

// Função de validação dos campos
(function() {
  "use strict";
  window.addEventListener(
    "load",
    function() {
      var forms = document.getElementsByClassName("needs-validation");
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener(
          "submit",
          function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
})();
