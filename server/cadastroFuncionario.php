<?php

require "connection/conexao.php";

$conn = conectaBanco();

$nome = $telefone = $telefoneCelular = $outroTelefone = $cpf = $dataIngressao = $cargo = $salario = $cep = $logradouro = $numero = $estado = $cidade = $bairro = $login = $senha = "";

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
    throw new Exception("A cidade do funcionário deve ser fornecido.");
if (!isset($_POST["bairro"]))
    throw new Exception("O bairro do funcionário deve ser fornecido.");
if (!isset($_POST["usuarioFuncionario"]))
    throw new Exception("O login do funcionário deve ser fornecido.");
if (!isset($_POST["senha"]))
    throw new Exception("A senha do funcionário deve ser fornecido.");


$nome = filtraEntradaForm($_POST["nome"]);
$telefone = filtraEntradaForm($_POST["telefone"]);
$telefoneCelular = filtraEntradaForm($_POST["telefone"]);
$outroTelefone = filtraEntradaForm($_POST["outroTelefone"]);
$cpf = filtraEntradaForm($_POST["cpf"]);
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
    throw new Exception("O telefone celular funcionário deve ser fornecido. $telefoneCelular aaaaa");
if ($outroTelefone == "")
    throw new Exception("O Outro telefone do funcionário deve ser fornecido.");
if ($cpf == "")
    throw new Exception("O cpf do funcionário deve ser fornecido.");
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
    throw new Exception("A cidade do funcionário deve ser fornecido.");
if ($bairro == "")
    throw new Exception("O bairro do funcionário deve ser fornecido.");
if ($login == "")
    throw new Exception("O login do funcionário deve ser fornecido.");
if ($senha == "")
    throw new Exception("A senha do funcionário deve ser fornecido.");

// verificaCpfJaCadastrado($cpf, $conn);

try 
{
    $conn->begin_transaction();

    $codFuncionario = cadastrarFuncionario($nome, $telefone, $telefoneCelular, $outroTelefone, $cpf, $cargo, $salario, $cep, $logradouro, $numero, $estado, $cidade, $bairro, $conn);
    cadastrarLoginFuncionario($login, $senha, $codFuncionario, $conn);
    echo "OK";
    $conn->commit();
    $conn->close();

} catch (Exception $e){
    $conn->rollback();
    http_response_code(400);
    throw new Exception($e);
}


    // $sql = "INSERT INTO funcionario(nome, telefone, cpf, endereco, telefoneContato, telefoneCelular, dataIngressao, cargo, salario)
    // VALUES ('$nome', '$telefone', '$cpf', '$endereco', '$telefoneContato', '$telefoneCelular', '$dataIngressao', '$cargo', '$salario')";

    // $sqlSelect = "SELECT f.codFuncionario FROM funcionario f where f.cpf = $cpf";
    // if ($conn->query($sql))
    //     $result = $conn->query($sqlSelect);
    // else
    //     echo "Erro na operação: " . $sql . "<br>" . $conn->error;

    // $codInserido = $result->fetch_assoc()["codFuncionario"];

    // $sqlUsuario = "INSERT INTO usuario(codFuncionario, desLogin, desSenha) VALUES ('$codInserido', '$login', '$senha')";
    // if ($conn->query($sqlUsuario))
    //     echo "Inserido com sucesso";
    // else
    //     echo "Erro na operação: " . $sql . "<br>" . $conn->error;

function cadastrarLoginFuncionario($login, $senha, $codFuncionario, $conn)  {
    $sqlCadastrarLoginFuncionario = "INSERT INTO usuario(codFuncionario, desLogin, desSenha) VALUES ('$codFuncionario', '$login', '$senha')";
    if (!$conn->query($sqlCadastrarLoginFuncionario))
        throw new Exception("Erro ao cadastrar Login do Usuário.");
}

function cadastrarFuncionario($nome, $telefone, $telefoneCelular, $outroTelefone, $cpf, $cargo, $salario, $cep, $logradouro, $numero, $estado, $cidade, $bairro, $conn) {
    $sqlCadastrarFuncionario = "INSERT INTO funcionario(nome, telefone, telefoneCelular, telefoneContato, cpf, cargo, salario, cep, logradouro, numero, estado, cidade, bairro)
        VALUES ('$nome', '$telefone', '$telefoneCelular', '$outroTelefone', '$cpf', '$cargo', '$salario', '$cep', '$logradouro', '$numero', '$estado', '$cidade', '$bairro')";

    $sqlSelectFuncionario = "SELECT f.codFuncionario FROM funcionario f where f.cpf = $cpf";
    if ($conn->query($sqlCadastrarFuncionario))
        $result = $conn->query($sqlSelectFuncionario);
    else 
        throw new Exception("Erro ao cadastrar Funcionário.");
    
    return $conn->insert_id;
}

function verificaCpfJaCadastrado($cpf, $conn) {
    $sqlVerificaCpf = "SELECT * from funcionario f where f.cpf = $cpf";

    if ($conn->query($sqlVerificaCpf) && $conn->query($sqlVerificaCpf)->num_rows > 0)
        throw new Exception("O CPF fornecido já está cadastrado.");
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

?>