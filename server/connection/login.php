<?php
  session_start();
  
  require_once "conexao.php";

  class Login {
    public $usuario;
    public $senha;
  }

  $msgErro = "";
  $usuario_autenticado = false;

  if ($_SERVER ["REQUEST_METHOD"] == "POST") {
    $login = new Login();

    $login->usuario = "";
    $login->senha = "";

    $login->usuario = filtroEntrada($_POST["usuario"]);
    $login->senha = filtroEntrada($_POST["senha"]);

    try {
      $conn = conectaBanco();
      
      $sql = "
        SELECT desLogin, desSenha FROM usuario
        WHERE desLogin = '$login->usuario';
      ";
  
      if (!$stmt = $conn->prepare($sql)){
        throw new Exception("Falha na operacao prepare: " . $conn->error);
      }
  
      if (!$stmt->execute()){
        throw new Exception("Falha na operacao execute: " . $stmt->error);
      }

      if (!$stmt->bind_result($usuario, $senha)) {
        throw new Exception("Falha na operação bind result: " . $conn->error);
      }
      
      if ($stmt->fetch() == 1) {
        if ($login->senha == $senha) {
          $usuario_autenticado = true;
          $_SESSION['autenticado'] = true;
        } else {
          $usuario_autenticado = false;
          $_SESSION['autenticado'] = false;
          throw new Exception("Senha incorreta!");
        }
      } else {
        $usuario_autenticado = false;
        $_SESSION['autenticado'] = "false";
        throw new Exception("E-mail ou senha inválidos");
      }
    } catch (Exception $e) {
      http_response_code(400);

      echo $e->getMessage();

      $msgErro = $e->getMessage();
    }
  }

  function filtroEntrada($dado) {

    $dado= trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);

    return $dado;
  }
?>