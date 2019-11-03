<?php
// $servidor = "127.0.0.1";
// $usuario = "root";
// $senha = "";
// $nomeBD = "makimobiliaria";
// // Inicia uma nova conexão com o servidor MySQL.
// // Em caso de sucesso na conexão, a variável $conn será
// // ser utilizada posteriormente para manipulação do banco
// // de dados através dessa conexão
// $conn = new mysqli($servidor, $usuario, $senha, $nomeBD);
// // Verifica se ocorreu alguma falha durante a conexão
// if ($conn->connect_error)
//  die("Falha na conexão com o MySQL: " . $conn->connect_error);
// else
//  echo "Conectado ao MySQL";

require "connection/conexao.php";

$conn = conectaBanco();

$nome = $_POST["nome"];
$telefone = $_POST["telefone"];
$cpf = $_POST["cpf"];
$endereco = $_POST["endereco"];
$telefoneContato = $_POST["telefoneContato"];
$telefoneCelular = $_POST["telefoneCelular"];
$dataIngressao = $_POST["dataIngressao"];
$cargo = $_POST["cargo"];
$salario = $_POST["salario"];
$login = $_POST['loginFuncionario'];
$senha = $_POST['senha'];

// function salvarFuncionario($nome, $telefone, $cpf, $endereco, $telefoneContato, $telefoneCelular, $dataIngressao, $cargo, $salario) {

    $sqlVerificaCpf = "SELECT * from funcionario f where f.cpf = $cpf";

    if ($conn->query($sqlVerificaCpf)->num_rows > 0)
        echo "CPF já existente";
    else {

    $sql = "INSERT INTO funcionario(nome, telefone, cpf, endereco, telefoneContato, telefoneCelular, dataIngressao, cargo, salario)
    VALUES ('$nome', '$telefone', '$cpf', '$endereco', '$telefoneContato', '$telefoneCelular', '$dataIngressao', '$cargo', '$salario')";

    $sqlSelect = "SELECT f.codFuncionario FROM funcionario f where f.cpf = $cpf";
    if ($conn->query($sql))
        $result = $conn->query($sqlSelect);
    else
        echo "Erro na operação: " . $sql . "<br>" . $conn->error;

    $codInserido = $result->fetch_assoc()["codFuncionario"];

    $sqlUsuario = "INSERT INTO usuario(codFuncionario, desLogin, desSenha) VALUES ('$codInserido', '$login', '$senha')";
    if ($conn->query($sqlUsuario))
        echo "Inserido com sucesso";
    else
        echo "Erro na operação: " . $sql . "<br>" . $conn->error;
    }
// }


// salvarFuncionario($nome, $telefone, $cpf, $endereco, $telefoneContato, $telefoneCelular, $dataIngressao, $cargo, $salario);


$conn->close();

?>