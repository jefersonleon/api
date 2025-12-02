<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Opcional: Primeiro apaga a foto da pasta para não deixar lixo
    $busca = $conn->query("SELECT foto FROM alunos WHERE id = $id");
    $aluno = $busca->fetch_assoc();
    if (!empty($aluno['foto']) && file_exists("imagens/" . $aluno['foto'])) {
        unlink("imagens/" . $aluno['foto']); // Deleta o arquivo físico
    }

    // Apaga do banco
    $conn->query("DELETE FROM alunos WHERE id = $id");
}

// Redireciona de volta
header("Location: index.php");
exit;
?>