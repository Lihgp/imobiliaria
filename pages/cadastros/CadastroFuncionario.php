<?php
  session_start();

  if (!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
    header('Location: ../../index.html');
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <title>Cadastro de Funcionário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Font Awesome  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css"
    />

    <!-- Css Principal -->
    <link rel="stylesheet" href="../../assets/css/style.css" />

    <!-- Importações para o Bootstrap -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Importações para usar as máscaras -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
      $(document).ready(function() {
        $("#formFuncionario").submit(function(e) {
          return false;
        });
      });

      function cadastrarFuncionario() {
        var formFuncionario = document.getElementById("formFuncionario");
        var formData = new FormData(formFuncionario);

        $.ajax({
          url: "../../server/cadastroFuncionario.php",
          method: "POST",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,

          success: function(result) {
            if (result.substring(0, 2) == "OK") {
              alert("Funcionário cadastrado com sucesso!");
              document.getElementById("formFuncionario").reset();
            } else {
              alert(result);
            }
          },
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          }
        });
      }
    </script>
  </head>
  <body class="box-section">
    <!-- Barra de Navegação RESTRITA-->
    <nav
      class="navbar navbar-expand-md navbar-main fixed-top"
      id="barraNavegacaoRestrita.show"
    >
      <div class="container-fluid">
        <!-- Logotipo -->
        <a class="navbar-brand" href="#">MAKI</a>
        <!-- Barra de navegação dobrável -->
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#collapsibleNavbar"
        >
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Opções da Barra de Navegação -->
        <div
          class="navbar-collapse collapse justify-content-end"
          id="collapsibleNavbar"
        >
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active home" href="../../index.html">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                Cadastro
              </a>
              <div
                class="dropdown-menu"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <a
                  class="dropdown-item cadastrar-funcionario"
                  href="../cadastros/CadastroFuncionario.php"
                  >Funcionários</a
                >
                <a
                  class="dropdown-item cadastrar-cliente"
                  href="../cadastros/CadastroCliente.html"
                  >Clientes</a
                >
                <a
                  class="dropdown-item cadastrar-imovel"
                  href="../cadastros/CadastroImovel.html"
                >
                  Imóveis</a
                >
              </div>
            </li>

            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                Listagem
              </a>
              <div
                class="dropdown-menu"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <a
                  class="dropdown-item pesquisar-funcionario"
                  href="../listagens/ListagemFuncionario.html"
                  >Funcionários</a
                >
                <a
                  class="dropdown-item pesquisar-cliente"
                  href="../listagens/ListagemCliente.html"
                  >Clientes</a
                >
                <a
                  class="dropdown-item pesquisar-imoveis"
                  href="../listagens/ListagemImoveis.html"
                >
                  Imóveis</a
                >
                <a
                  class="dropdown-item pesquisar-interesses"
                  href="../listagens/ListagemInteresses.html"
                >
                  Interesses</a
                >
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link click-sair" href="../../index.html">Sair</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--Fim Barra de Navegação-->
    <!-- Início parte de cadastro do funcionário -->
    <section class="box-section" style="margin-top: 30px">
      <div class="container caixa-telas-restritas">
        <h2 class="titulo-telas-restritas">Cadastrar Funcionário</h2>
        <hr />
        <!-- action="../../server/cadastroFuncionario.php" -->
        <form
          id="formFuncionario"
          name="formFuncionario"
          method="post"
          novalidate
          onsubmit="cadastrarFuncionario()"
        >
          <h4 class="subtitulo">Dados Pessoais e Gerais</h4>
          <div class="form-group row">
            <label for="nome" class="col-sm-1 col-form-label label-cadastro"
              >Nome</label
            >
            <div class="col-sm-11">
              <input
                required
                maxlength="255"
                type="text"
                class="form-control"
                name="nome"
                id="nome"
                placeholder="Nome completo"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="telefone" class="col-sm-1 col-form-label label-cadastro"
              >Telefone</label
            >
            <div class="col-sm-2">
              <input
                required
                name="telefone"
                maxlength="10"
                class="form-control"
                id="telefone"
              />
            </div>
            <label for="celular" class="col-sm-2 col-form-label label-cadastro"
              >Telefone Celular</label
            >
            <div class="col-sm-2">
              <input
                required
                name="celular"
                maxlength="10"
                class="form-control"
                id="celular"
              />
            </div>
            <label
              for="outroTelefone"
              class="col-sm-2 col-form-label label-cadastro"
              >Outro Telefone</label
            >
            <div class="col-sm-2">
              <input
                required
                name="outroTelefone"
                maxlength="10"
                class="form-control"
                id="outroTelefone"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="cpf" class="col-sm-1 col-form-label label-cadastro"
              >Cpf</label
            >
            <div class="col-sm-2">
              <input
                required
                type="text"
                class="form-control"
                name="cpf"
                id="cpf"
              />
            </div>
            <label
              for="dataIngresso"
              class="col-sm-2 col-form-label label-cadastro"
              >Data de Ingresso</label
            >
            <div class="col-sm-2">
              <input
                required
                name="dataIngresso"
                class="form-control"
                id="dataIngresso"
                placeholder="Ex.: 00/00/0000"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="cargo" class="col-sm-1 col-form-label label-cadastro"
              >Cargo</label
            >
            <div class="col-sm-6">
              <select required class="form-control" id="cargo" name="cargo">
                <option value="0">Solteiro</option>
                <option value="1">Casado</option>
                <option value="2">Separado</option>
                <option value="3">Divorciado</option>
                <option value="4">Viúvo</option>
              </select>
            </div>
            <label for="salario" class="col-sm-2 col-form-label label-cadastro"
              >Salário</label
            >
            <div class="col-sm-2">
              <input
                required
                maxlength="24"
                type="text"
                name="salario"
                class="form-control"
                id="salario"
              />
            </div>
          </div>
          <h4 class="subtitulo">Endereço</h4>
          <div class="form-group row">
            <label for="cep" class="col-sm-1 col-form-label label-cadastro"
              >Cep</label
            >
            <div class="col-sm-2">
              <input
                required
                type="text"
                class="form-control"
                id="cep"
                name="cep"
              />
            </div>
            <label
              for="logradouro"
              class="col-sm-1 col-form-label label-cadastro"
              >Logradouro</label
            >
            <div class="col-sm-5">
              <input
                required
                maxlength="255"
                type="text"
                name="logradouro"
                class="form-control"
                id="logradouro"
              />
            </div>
            <label for="numero" class="col-sm-1 col-form-label label-cadastro"
              >Número</label
            >
            <div class="col-sm-2">
              <input
                required
                maxlength="4"
                class="form-control"
                id="numero"
                name="numero"
              />
            </div>
          </div>

          <div class="form-group row">
            <label for="estado" class="col-sm-1 col-form-label label-cadastro"
              >Estado</label
            >
            <div class="col-sm-2">
              <input
                required
                type="text"
                name="estado"
                class="form-control"
                id="estado"
                placeholder="UF"
              />
            </div>

            <label for="cidade" class="col-sm-1 col-form-label label-cadastro"
              >Cidade</label
            >
            <div class="col-sm-4">
              <input
                required
                maxlength="255"
                type="text"
                name="cidade"
                class="form-control"
                id="cidade"
              />
            </div>

            <label for="bairro" class="col-sm-1 col-form-label label-cadastro"
              >Bairro</label
            >
            <div class="col-sm-3">
              <input
                required
                maxlength="255"
                type="text"
                name="bairro"
                class="form-control"
                id="bairro"
              />
            </div>
          </div>
          <h4 class="subtitulo">Login</h4>
          <div class="form-group row">
            <label
              for="usuarioFuncionario"
              class="col-sm-1 col-form-label label-cadastro"
              >Login</label
            >
            <div class="col-sm-5">
              <input
                required
                maxlength="30"
                type="text"
                name="usuarioFuncionario"
                class="form-control"
                id="usuarioFuncionario"
              />
            </div>
            <label for="senha" class="col-sm-1 col-form-label label-cadastro"
              >Senha</label
            >
            <div class="col-sm-5">
              <input
                required
                maxlength="128"
                type="text"
                name="senha"
                class="form-control"
                id="senha"
              />
            </div>
          </div>
          <div><label
              >Imagem de perfil:
              <input type="file" name="image[]" multiple="multiple"
            /></label>
            <input type="submit" value="Submit" /></div>
          <br /><br />
          <div class="form-group row">
            <button
              type="submit"
              class="btn btn-roxo"
              style="width: 200px; margin: 0 auto"
            >
              Salvar
            </button>
          </div>
        </form>
        <!-- Fim parte de cadastrar funcionário -->
      </div>
    </section>
    <!-- JavaScript -->
    <script src="../../assets/js/script.js"></script>
    <script src="../../assets/js/scriptEndereco.js"></script>
  </body>
</html>
<style></style>
