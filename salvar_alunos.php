<?php
include 'conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$caminho_foto = "";

// Verifica se enviou arquivo
if (isset($_FILES['arquivo_foto'])) {
    // Gera um nome único para não sobrescrever (ex: 20231201_999.jpg)
    $novo_nome = date("YmdHis") . "_" . basename($_FILES['arquivo_foto']['name']);
    $diretorio = "imagens/"; // A pasta onde vai salvar
    
    // Tenta mover o arquivo temporário para a pasta oficial
    if (move_uploaded_file($_FILES['arquivo_foto']['tmp_name'], $diretorio . $novo_nome)) {
        // Se deu certo, guardamos o caminho relativo
        $caminho_foto = $novo_nome; 
    }
}

// Salva no banco apenas o NOME do arquivo
$sql = "INSERT INTO alunos (nome, email, foto) VALUES ('$nome', '$email', '$caminho_foto')";
$conn->query($sql);
header("Location: index.php");
?>