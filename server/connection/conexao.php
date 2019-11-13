<?php
define("HOST", "ns590.hostgator.com.br");
define("USER", "makimo61_makizer");
define("PASSWORD", "makizer");
define("DATABASE", "makimo61_makimobiliaria");

function conectaBanco() {
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($conn->connect_error)
     throw new Exception("Falha na conexão com o MySQL: " . $conn->connect_error);

    return $conn;
}
?>
