<?php
// Define que a resposta será JSON (O Android precisa disso)
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *"); // Libera acesso externo
include '../conexao.php'; // Volta uma pasta para achar a conexão

// Prepara a resposta padrão
$response = array("sucesso" => false, "msg" => "");

// Verifica se recebeu os dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $caminho_banco = null;

    // LÓGICA DE UPLOAD DA FOTO (Igual da Web, mas silenciosa)
    if (isset($_FILES['foto'])) {
        $pasta_destino = "../imagens/"; // Salva na pasta imagens na raiz
        
        // Garante que a pasta existe
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }

        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        // Se não tiver extensão, assume jpg
        if(empty($extensao)) $extensao = "jpg";
        
        $novo_nome = date("YmdHis") . "_" . rand(100,999) . "." . $extensao;
        
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $pasta_destino . $novo_nome)) {
            $caminho_banco = $novo_nome;
        }
    }

    // INSERE NO BANCO
    if (!empty($nome) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO alunos (nome, email, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $caminho_banco);

        if ($stmt->execute()) {
            $response["sucesso"] = true;
            $response["msg"] = "Aluno cadastrado com sucesso!";
        } else {
            $response["msg"] = "Erro SQL: " . $conn->error;
        }
        $stmt->close();
    } else {
        $response["msg"] = "Nome e Email são obrigatórios";
    }

} else {
    $response["msg"] = "Método inválido. Use POST.";
}

// Responde para o Android
echo json_encode($response);
$conn->close();
?>