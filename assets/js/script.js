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

// Função para alterar os campos do formulário ao selecionar CASA ou APARTAMENTO no cadastro de imóveis
$("#categoriaImovel").change(function() {
  let tipoImovel = document.getElementById("categoriaImovel").value;
  if (tipoImovel === "casa" || tipoImovel === "") {
    $("#formApartamento").css("display", "none");
  } else if (tipoImovel === "apartamento") {
    $("#formApartamento").css("display", "inline");
  }
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

// Tudo que será feito PRIMEIRO
$(document).ready(function() {
  // Máscaras para os campos input
  // Dinheiro
  $(
    "#vlrImovel, #vlrCondominio, #area, #precoMinimo, #precoMaximo, #salario"
  ).mask("#.##0,00", {
    reverse: true
  });
  // Cep
  $("#cep").mask("00000-000");
  // Um número
  $("#numero").mask("#");
  // Dois números
  $(
    "#andar, #qtdQuartos, #qtdSuites, #qtdSalaEstar, #qtdSalaJantar, #nroVagaGaragem"
  ).mask("00");
  // Cpf
  $("#cpf").mask("000.000.000-00");
  // Celular
  $("#celular, #telefone, #outroTelefone").mask("#0000-0000", {
    reverse: true
  });
  // Duas letras
  $("#estado").mask("AA");
  // Data
  $("#dataIngresso").mask("00/00/0000");
});
