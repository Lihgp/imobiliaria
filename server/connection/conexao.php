<?php
define("HOST", "127.0.0.1");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "makimobiliaria");

function conectaBanco() {
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($conn->connect_error)
     throw new Exception("Falha na conexão com o MySQL: " . $conn->connect_error);

    return $conn;
}
?>
