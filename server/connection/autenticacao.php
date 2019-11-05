<?php

function filtraEntradaForm($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function verificaLogin($conn) {
  if (!isset($_POST['usuario'], $_POST['senha']))
    return false;

    $usuario = filtraEntradaForm($_POST['usuario']);
    $senha = filtraEntradaForm($_POST['senha']);

    if ($usuario == "")
        return false;
    if ($senha == "")
        return false;

    
  $SQL = "
  SELECT desSenha 
  FROM usuario
  WHERE desLogin = ?
  LIMIT 1
";
  
$stmt = $conn->prepare($SQL);
$stmt->bind_param('s', $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1)
  {
    $stmt->bind_result($desSenha);
    $stmt->fetch();
    
    if (hash_equals($desSenha, $senha)) {
        return true;
    }
  }
  return false;
}


function checkUsuarioLogadoOrDie($conn)
{
  if (!verificaLogin($conn))
  {
    $conn->close();
    header("Location: ../../index.html");
  }
}
?>