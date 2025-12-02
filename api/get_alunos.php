<?php
header('Content-Type: application/json; charset=utf-8');
include '../conexao.php';

// Defina o endereço do seu site aqui (onde estão as imagens)
$url_base_imagens = "http://teste.infinitydev.com.br/imagens/";

$sql = "SELECT id, nome, email, foto FROM alunos";
$result = $conn->query($sql);

$dados = array();

while($row = $result->fetch_assoc()) {
    // Lógica: Se tiver foto, concatena o site + nome da foto
    if (!empty($row['foto'])) {
        $row['foto_url'] = $url_base_imagens . $row['foto'];
    } else {
        // Se não tiver foto, manda null ou uma imagem padrão
        $row['foto_url'] = null; 
        // ou: $url_base_imagens . "sem_foto.png";
    }
    
    $dados[] = $row;
}

echo json_encode($dados);
$conn->close();
?>