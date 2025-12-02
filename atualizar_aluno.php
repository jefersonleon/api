<?php
include 'conexao.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];

// Verifica se enviou UMA NOVA foto
if (isset($_FILES['arquivo_foto']) && $_FILES['arquivo_foto']['error'] == 0) {
    
    // 1. Apaga a foto antiga para não encher o servidor (Opcional)
    $busca = $conn->query("SELECT foto FROM alunos WHERE id = $id");
    $antiga = $busca->fetch_assoc();
    if (!empty($antiga['foto']) && file_exists("imagens/" . $antiga['foto'])) {
        unlink("imagens/" . $antiga['foto']);
    }

    // 2. Faz o upload da nova
    $extensao = pathinfo($_FILES['arquivo_foto']['name'], PATHINFO_EXTENSION);
    $novo_nome = date("YmdHis") . "_" . rand(100,999) . "." . $extensao;
    move_uploaded_file($_FILES['arquivo_foto']['tmp_name'], "imagens/" . $novo_nome);

    // 3. Atualiza com foto
    $sql = "UPDATE alunos SET nome='$nome', email='$email', foto='$novo_nome' WHERE id=$id";

} else {
    // 4. Se não mandou foto, atualiza só os textos
    $sql = "UPDATE alunos SET nome='$nome', email='$email' WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
    header("Location: index.php"); // Sucesso, volta pra lista
} else {
    echo "Erro ao atualizar: " . $conn->error;
}
?>