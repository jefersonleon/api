<?php
header('Content-Type: application/json; charset=utf-8');
include '../conexao.php';

// PULO DO GATO: Ler o RAW input (Corpo da requisição)
$json = file_get_contents('php://input');
$data = json_decode($json, true); // Transforma o JSON do Android em Array PHP

// Validação básica
if(!isset($data['nome']) || !isset($data['email'])){
    echo json_encode(["sucesso" => false, "msg" => "Dados incompletos"]);
    exit;
}

$nome = $conn->real_escape_string($data['nome']); // Segurança básica
$email = $conn->real_escape_string($data['email']);

$sql = "INSERT INTO alunos (nome, email) VALUES ('$nome', '$email')";

if ($conn->query($sql) === TRUE) {
    // Retorna o ID criado para o Android saber
    echo json_encode(["sucesso" => true, "id" => $conn->insert_id]);
} else {
    echo json_encode(["sucesso" => false, "msg" => "Erro SQL: " . $conn->error]);
}

$conn->close();
?>