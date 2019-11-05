<?php

require "connection/conexao.php";

class Cliente 
{
	public $codCliente;
	public $nome;
	public $cpf;
	public $telefoneCelular;
	public $sexo;
}
try
{
	$conn = conectaBanco();

	$nome = $telefoneCelular = $cpf = $sexo = "";

	if (isset($_GET["nome"]))
		$nome = $_GET["nome"];

	if (isset($_GET["cpf"]))
		$cpf = $_GET["cpf"];
		
	if (isset($_GET["telefoneCelular"]))
		$telefoneCelular = $_GET["telefoneCelular"];

	if (isset($_GET["sexo"]))
		$sexo = $_GET["sexo"];

	$SQL = "
		SELECT *
		FROM clienteProprietario
		WHERE (nome like '%$nome%')
		AND (cpf like '%$cpf%')
		AND (telefoneCelular like '%$telefoneCelular%')
		AND (sexo like '$sexo' or '$sexo' like 'Todos')
	";
	
	
	if (! $result = $conn->query($SQL))
		throw new Exception('Ocorreu uma falha ao buscar o cliente: ' . $conn->error);

	 // Prepara a consulta
	 if (!$stmt = $conn->prepare($SQL))
	 throw new Exception("Falha na operacao prepare: " . $conn->error);

	// Executa a consulta
	if (!$stmt->execute())
		throw new Exception("Falha na operacao execute: " . $stmt->error);


	$arrayClientes = array();
	while ($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$arrayClientes[] = $row;
	} 
	echo json_encode($arrayClientes);
	
}
catch (Exception $e)
{
	echo $e->getMessage();
}

if ($conn != null)
	$conn->close();

?>