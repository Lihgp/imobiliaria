<?php

require "connection/conexao.php";

$conn = conectaBanco();

$nome = $telefone = $telefoneCelular = $outroTelefone = $cpf = $dataIngresso = $cargo = $salario = $cep = $logradouro = $numero = $estado = $cidade = $bairro = $login = $senha = "";

if (!isset($_POST["nome"]))
    throw new Exception("O nome do funcionário deve ser fornecido.");
if (!isset($_POST["telefone"]))
    throw new Exception("O telefone funcionário deve ser fornecido.");
if (!isset($_POST["telefone"]))
    throw new Exception("O telefone celular funcionário deve ser fornecido.");
if (!isset($_POST["outroTelefone"]))
    throw new Exception("O Outro telefone do funcionário deve ser fornecido.");
if (!isset($_POST["cpf"]))
    throw new Exception("O cpf do funcionário deve ser fornecido.");
if (!isset($_POST["dataIngresso"]))
    throw new Exception("A data de ingressão do funcionário deve ser fornecida.");
if (!isset($_POST["cargo"]))
    throw new Exception("O cargo do funcionário deve ser fornecido.");
if (!isset($_POST["salario"]))
    throw new Exception("O salário do funcionário deve ser fornecido.");
if (!isset($_POST["cep"]))
    throw new Exception("O CEP do funcionário deve ser fornecido.");
if (!isset($_POST["logradouro"]))
    throw new Exception("O logradouro do funcionário deve ser fornecido.");
if (!isset($_POST["numero"]))
    throw new Exception("O número do funcionário deve ser fornecido.");
if (!isset($_POST["estado"]))
    throw new Exception("O estado do funcionário deve ser fornecido.");
if (!isset($_POST["cidade"]))
    throw new Exception("A cidade do funcionário deve ser fornecida.");
if (!isset($_POST["bairro"]))
    throw new Exception("O bairro do funcionário deve ser fornecido.");
if (!isset($_POST["usuarioFuncionario"]))
    throw new Exception("O login do funcionário deve ser fornecido.");
if (!isset($_POST["senha"]))
    throw new Exception("A senha do funcionário deve ser fornecida.");


$nome = filtraEntradaForm($_POST["nome"]);
$telefone = filtraEntradaForm($_POST["telefone"]);
$telefoneCelular = filtraEntradaForm($_POST["telefone"]);
$outroTelefone = filtraEntradaForm($_POST["outroTelefone"]);
$cpf = filtraEntradaForm($_POST["cpf"]);
$dataIngresso = formataDataSalvarBanco(filtraEntradaForm($_POST["dataIngresso"]));
$cargo = filtraEntradaForm($_POST["cargo"]);
$salario = converteDecimalSalvarBanco(filtraEntradaForm($_POST["salario"]));
$cep = filtraEntradaForm($_POST["cep"]);
$logradouro = filtraEntradaForm($_POST["logradouro"]);
$numero = filtraEntradaForm($_POST["numero"]);
$estado = filtraEntradaForm($_POST["estado"]);
$cidade = filtraEntradaForm($_POST["cidade"]);
$bairro = filtraEntradaForm($_POST["bairro"]);
$login = filtraEntradaForm($_POST["usuarioFuncionario"]);
$senha = filtraEntradaForm($_POST["senha"]);

if ($nome == "")
    throw new Exception("O nome do funcionário deve ser fornecido.");
if ($telefone == "")
    throw new Exception("O telefone funcionário deve ser fornecido.");
if ($telefoneCelular == "")
    throw new Exception("O telefone celular funcionário deve ser fornecido.");
if ($outroTelefone == "")
    throw new Exception("O Outro telefone do funcionário deve ser fornecido.");
if ($cpf == "")
    throw new Exception("O cpf do funcionário deve ser fornecido.");
if ($dataIngresso == "")
    throw new Exception("A data de ingressão do funcionário deve ser fornecida.");
if ($cargo == "")
    throw new Exception("O cargo do funcionário deve ser fornecido.");
if ($salario == "")
    throw new Exception("O salário do funcionário deve ser fornecido.");
if ($cep == "")
    throw new Exception("O CEP do funcionário deve ser fornecido.");
if ($logradouro == "")
    throw new Exception("O logradouro do funcionário deve ser fornecido.");
if ($numero == "")
    throw new Exception("O número do funcionário deve ser fornecido.");
if ($estado == "")
    throw new Exception("O estado do funcionário deve ser fornecido.");
if ($cidade == "")
    throw new Exception("A cidade do funcionário deve ser fornecida.");
if ($bairro == "")
    throw new Exception("O bairro do funcionário deve ser fornecido.");
if ($login == "")
    throw new Exception("O login do funcionário deve ser fornecido.");
if ($senha == "")
    throw new Exception("A senha do funcionário deve ser fornecida.");

verificaCpfJaCadastrado($cpf, $conn);

try 
{
    $conn->begin_transaction();

    $codFuncionario = cadastrarFuncionario($nome, $telefone, $telefoneCelular, $outroTelefone, $cpf, $dataIngresso, $cargo, $salario, $cep, $logradouro, $numero, $estado, $cidade, $bairro, $conn);
    cadastrarLoginFuncionario($login, $senha, $codFuncionario, $conn);
    echo "OK";
    $conn->commit();
    $conn->close();

} catch (Exception $e){
    $conn->rollback();
    $conn->close();
    http_response_code(400);
    throw new Exception($e);
}

function cadastrarLoginFuncionario($login, $senha, $codFuncionario, $conn)  {

    $sqlVerificaLoginFuncionario = "SELECT * from usuario WHERE desLogin like '$login'";

    if ($result = $conn->query($sqlVerificaLoginFuncionario)) {
        if ($result->num_rows > 0)
            throw new Exception("O Login fornecido já está cadastrado.");
       } else {
           throw new Exception("Falha na operacao query do login: ". $conn->error);
       }

    $sqlCadastrarLoginFuncionario = "INSERT INTO usuario(codFuncionario, desLogin, desSenha) VALUES (?, ?, ?)";

    if (!$stmt = $conn->prepare($sqlCadastrarLoginFuncionario))
        throw new Exception("Falha na operacao prepare: " . $conn->error);

    if (!$stmt->bind_param("iss", $codFuncionario, $login, $senha))
        throw new Exception("Falha na operacao bind_param: " . $stmt->error);

    if (!$result = $stmt->execute())
        throw new Exception("Falha na operacao execute: " . $stmt->error);
}

function cadastrarFuncionario($nome, $telefone, $telefoneCelular, $outroTelefone, $cpf, $dataIngresso, $cargo, $salario, $cep, $logradouro, $numero, $estado, $cidade, $bairro, $conn) {
    $sqlCadastrarFuncionario = "INSERT INTO funcionario(nome, telefone, telefoneCelular, telefoneContato, cpf, dataIngressao, cargo, salario, cep, logradouro, numero, estado, cidade, bairro)
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if (!$stmt = $conn->prepare($sqlCadastrarFuncionario))
        throw new Exception("Falha na operacao prepare: " . $conn->error);

    if (!$stmt->bind_param("ssssssidssisss", $nome, $telefone, $telefoneCelular, $outroTelefone, $cpf, $dataIngresso, $cargo, $salario, $cep, $logradouro, $numero, $estado, $cidade, $bairro))
        throw new Exception("Falha na operacao bind_param: " . $stmt->error);

    if (!$stmt->execute())
        throw new Exception("Falha na operacao execute: " . $stmt->error);
    
    return $conn->insert_id;
}

function verificaCpfJaCadastrado($cpf, $conn) {
    $sqlVerificaCpf = "SELECT f.codFuncionario from funcionario f where f.cpf = '$cpf'";

   if ($result = $conn->query($sqlVerificaCpf)) {
    if ($result->num_rows > 0)
        throw new Exception("O CPF fornecido já está cadastrado.");
   } else {
       throw new Exception("Falha na operacao query: ". $conn->error);
   }
}

function filtraEntradaForm($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function converteDecimalSalvarBanco($valor) {
    if ($valor == "") return 0;
    else {
        $valor = str_replace(".","", $valor);
        $valor = str_replace(",",".", $valor);
        $valor = floatval($valor);
    }
    return $valor;
}

function formataDataSalvarBanco($data) {
    $data = substr($data, -4)."-".substr($data, 3, 2)."-".substr($data, 0, 2);
    return $data;
}

?>