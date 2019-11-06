<?php

require "connection/conexao.php";

$conn = conectaBanco();

$nome = $cpf = $sexo = $estadoCivil = $celular = $outroTelefone = $email = $profissao = $cep = $logradouro = $numero = $estado = $cidade = $bairro = "";

try {
    if (!isset($_POST["nome"]))
    throw new Exception("O nome do funcionário deve ser fornecido.");
    if (!isset($_POST["cpf"]))
        throw new Exception("O telefone funcionário deve ser fornecido.");
    if (!isset($_POST["sexo"]))
        throw new Exception("O telefone celular funcionário deve ser fornecido.");
    if (!isset($_POST["estadoCivil"]))
        throw new Exception("O Outro telefone do funcionário deve ser fornecido.");
    if (!isset($_POST["celular"]))
        throw new Exception("O cpf do funcionário deve ser fornecido.");
    if (!isset($_POST["outroTelefone"]))
        throw new Exception("A data de ingressão do funcionário deve ser fornecida.");
    if (!isset($_POST["email"]))
        throw new Exception("O cargo do funcionário deve ser fornecido.");
    if (!isset($_POST["profissao"]))
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
    
    $nome = filtraEntradaForm($_POST["nome"]);
    $cpf = filtraEntradaForm($_POST["cpf"]);
    $sexo = filtraEntradaForm($_POST["sexo"]);
    $estadoCivil = filtraEntradaForm($_POST["estadoCivil"]);
    $celular = filtraEntradaForm($_POST["celular"]);
    $outroTelefone = filtraEntradaForm($_POST["outroTelefone"]);
    $email = filtraEntradaForm($_POST["email"]);
    $profissao = filtraEntradaForm($_POST["profissao"]);
    $cep = filtraEntradaForm($_POST["cep"]);
    $logradouro = filtraEntradaForm($_POST["logradouro"]);
    $numero = filtraEntradaForm($_POST["numero"]);
    $estado = filtraEntradaForm($_POST["estado"]);
    $cidade = filtraEntradaForm($_POST["cidade"]);
    $bairro = filtraEntradaForm($_POST["bairro"]);
    
    if ($nome == "")
        throw new Exception("O nome do funcionário deve ser fornecido.");
    if ($cpf == "")
        throw new Exception("O telefone funcionário deve ser fornecido.");
    if ($sexo == "")
        throw new Exception("O telefone celular funcionário deve ser fornecido.");
    if ($estadoCivil == "")
        throw new Exception("O Outro telefone do funcionário deve ser fornecido.");
    if ($celular == "")
        throw new Exception("O cpf do funcionário deve ser fornecido.");
    if ($outroTelefone == "")
        throw new Exception("A data de ingressão do funcionário deve ser fornecida.");
    if ($email == "")
        throw new Exception("O cargo do funcionário deve ser fornecido.");
    if ($profissao == "")
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
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

try {
    cadastrarCliente($nome, $cpf, $sexo, $estadoCivil, $celular, $outroTelefone, $email, $profissao, $cep, $logradouro, $numero, $estado, $cidade, $bairro, $conn);
    echo "OK";
    $conn->close;
} catch (Exception $e) {
    $conn->close();
    http_response_code(400);
    throw new Exception($e);
}

function cadastrarCliente($nome, $cpf, $sexo, $estadoCivil, $celular, $outroTelefone, $email, $profissao, $cep, $logradouro, $numero, $estado, $cidade, $bairro, $conn) {
    $sqlCadastrarCliente = "INSERT INTO clienteproprietario(cpf, nome, telefoneCelular, telefoneOutro, email, sexo, estadoCivil, profissao, cep, logradouro, numero, bairro, cidade, estado)
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        if (!$stmt = $conn->prepare($sqlCadastrarCliente))
        throw new Exception("Falha na operacao prepare: " . $conn->error);
        
        if (!$stmt->bind_param("ssssssssssisss", $cpf, $nome, $celular, $outroTelefone, $email, $sexo, $estadoCivil, $profissao, $cep, $logradouro, $numero, $bairro, $cidade, $estado))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);
    
        if (!$stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

function filtraEntradaForm($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>