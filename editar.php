<?php
include 'conexao.php';

$id = $_GET['id'];
$sql = "SELECT * FROM alunos WHERE id = $id";
$result = $conn->query($sql);
$aluno = $result->fetch_assoc();

// Se não achar o aluno, volta
if (!$aluno) { header("Location: index.php"); exit; }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Editar Aluno</title>
    <style>
        :root {
            --primary: #4a90e2;
            --secondary: #6c757d;
            --success: #28a745;
            --bg: #f4f6f9;
            --card-bg: #ffffff;
            --text: #2c3e50;
            --border: #ced4da;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Centraliza verticalmente */
        }

        .container {
            background: var(--card-bg);
            padding: 30px;
            width: 100%;
            max-width: 500px; /* Limite para PC */
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            box-sizing: border-box; /* Garante que padding não estoure a largura */
        }

        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: var(--primary);
            font-size: 1.8rem;
        }

        /* Estilo da Foto */
        .img-container {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        img.preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f0f0f0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        img.preview:hover {
            transform: scale(1.05);
            border-color: var(--primary);
        }

        .img-label {
            display: block;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #888;
        }

        /* Campos do Formulário */
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            margin-top: 15px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 5px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box; /* Importante para responsividade */
            transition: border-color 0.3s;
            background-color: #fafafa;
        }

        input:focus {
            border-color: var(--primary);
            outline: none;
            background-color: #fff;
        }

        input[type="file"] {
            padding: 10px;
            background: white;
            font-size: 0.9rem;
        }

        /* Botões */
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-direction: column; /* Em celular fica um embaixo do outro */
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #357abd;
            transform: translateY(-2px);
        }

        .btn-cancel {
            display: block;
            text-align: center;
            padding: 14px;
            background-color: transparent;
            color: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background-color: #e9ecef;
            color: #333;
        }

        /* Ajuste para telas maiores (Tablet/PC) */
        @media (min-width: 600px) {
            .btn-group {
                flex-direction: row; /* Botões lado a lado no PC */
            }
            button, .btn-cancel {
                width: 50%; /* Divide o espaço */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Editar Aluno</h2>

    <form action="atualizar_aluno.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">
        
        <div class="img-container">
            <?php 
                $foto = "imagens/" . $aluno['foto'];
                if(empty($aluno['foto']) || !file_exists($foto)) {
                    $foto = "https://cdn-icons-png.flaticon.com/512/149/149071.png";
                }
            ?>
            <img src="<?php echo $foto; ?>" class="preview" alt="Foto Atual">
            <span class="img-label">Foto Atual</span>
        </div>

        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" value="<?php echo $aluno['nome']; ?>" required placeholder="Digite o nome">

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?php echo $aluno['email']; ?>" required placeholder="Digite o e-mail">

        <label for="foto">Trocar Foto (Opcional)</label>
        <input type="file" id="foto" name="arquivo_foto" accept="image/*">

        <div class="btn-group">
            <a href="index.php" class="btn-cancel">Cancelar</a>
            <button type="submit">Salvar Alterações</button>
        </div>
    </form>
</div>

</body>
</html>