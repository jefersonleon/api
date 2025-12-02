<?php
// conexao.php
$host = "localhost";
$user = "jeferson_bdteste";
$pass = "teste1234";
$db   = "jeferson_bdteste";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    // Retornar JSON de erro caso seja chamado pela API ajuda no debug
    die(json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]));
}

// Define utf8 para evitar problemas de acentuação no Android
$conn->set_charset("utf8");
?>