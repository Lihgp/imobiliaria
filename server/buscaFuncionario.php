<?php

require "connection/conexao.php";

class Funcionario 
{
	public $codFuncionario;
	public $nome;
	public $cpf;
	public $telefone;
	public $cargo;
	public $salario;
	public $telefoneCelular;
}
try
{
	$conn = conectaBanco();

	$nome = $telefoneCelular = $telefone = $cpf = $cargo = $salario = "";

	if (isset($_GET["nome"]))
		$nome = $_GET["nome"];

	if (isset($_GET["cpf"]))
		$cpf = $_GET["cpf"];
		
	if (isset($_GET["telefone"]))
		$telefone = $_GET["telefone"];

	if (isset($_GET["telefoneCelular"]))
		$telefoneCelular = $_GET["telefoneCelular"];

	if (isset($_GET["cargo"]))
		$cargo = $_GET["cargo"];

	if (isset($_GET["salario"]))
		$salario = $_GET["salario"];

	

	$SQL = "
		SELECT *
		FROM funcionario
		WHERE (nome like '%$nome%')
		AND (cpf like '%$cpf%')
		AND (telefone like '%$telefone%')
		AND (telefoneCelular like '%$telefoneCelular%')
		AND (cargo like '$cargo' or '$cargo' like 'Todos')
	";
	
	
	if (! $result = $conn->query($SQL))
		throw new Exception('Ocorreu uma falha ao buscar o endereco: ' . $conn->error);

	 // Prepara a consulta
	 if (!$stmt = $conn->prepare($SQL))
	 throw new Exception("Falha na operacao prepare: " . $conn->error);

	// Executa a consulta
	if (!$stmt->execute())
		throw new Exception("Falha na operacao execute: " . $stmt->error);


	$arrayFuncionarios = array();
	while ($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$arrayFuncionarios[] = $row;
	} 
	echo json_encode($arrayFuncionarios);
	
}
catch (Exception $e)
{
	echo $e->getMessage();
}

if ($conn != null)
	$conn->close();

?>