<?php

require "connection/conexao.php";

class Endereco 
{
	public $codEndereco;
	public $cep;
    public $logradouro;
    public $bairro;
    public $cidade;
    public $estado;
}
try
{
    $conn = conectaBanco();
    
    $cep = "";

	if (isset($_GET["cep"]))
        $cep = $_GET["cep"];
        
	$SQL = "
		SELECT *
        FROM endereco
        WHERE cep like '%$cep%'
	";
	
    if (!$result = $conn->query($SQL))
        throw new Exception('Ocorreu uma falha ao buscar o endereco: ' . $conn->error);

        $jsonTeste = '{"nome":"Jason Jones", "idade":38, "sexo": "M"}';

    if ($result->num_rows > 0)
    {
        throw new Exception($result->num_rows);

        $row = $result->fetch_assoc();

        $endereco = new Endereco();

        $endereco->codEndereco = $row["codEndereco"];
        $endereco->cep = $row["cep"];
        $endereco->logradouro = $row["logradouro"];
        $endereco->bairro = $row["bairro"];
        $endereco->cidade = $row["cidade"];
        $endereco->estado = $row["estado"];
        
        $jsonStr = json_encode($endereco, JSON_UNESCAPED_UNICODE);

        echo $jsonStr;
        
        if (! $jsonStr = json_encode($endereco, JSON_UNESCAPED_UNICODE)) // Para trazer os acentos
            throw new Exception("Falha na funcao json_encode do PHP");
    }  else {
        echo null;
    }

    
}
catch (Exception $e)
{
    http_response_code(500);

    $msgErro = $e->getMessage();
    echo $msgErro;
}

if ($conn != null)
    $conn->close();

?>