<?php

require "connection/conexao.php";

class Proprietario 
{
	public $codCliente;
	public $nome;
	public $cpf;
}
try
{
    $conn = conectaBanco();
    
	$SQL = "
		SELECT codCliente, nome, cpf
		FROM clienteProprietario
	";
	
	
	if (! $result = $conn->query($SQL))
		throw new Exception('Ocorreu uma falha ao buscar o proprietario: ' . $conn->error);

	 // Prepara a consulta
	 if (!$stmt = $conn->prepare($SQL))
	 throw new Exception("Falha na operacao prepare: " . $conn->error);

	// Executa a consulta
	if (!$stmt->execute())
		throw new Exception("Falha na operacao execute: " . $stmt->error);


	$arrayProprietarios= array();
	while ($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$arrayProprietarios[] = $row;
	} 
	echo json_encode($arrayProprietarios);
	
}
catch (Exception $e)
{
	echo $e->getMessage();
}

if ($conn != null)
	$conn->close();

?>