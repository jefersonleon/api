<?php
include 'conexao.php'; 

// LÓGICA DE PESQUISA
$busca = "";
$filtro_sql = "";

if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    // Protege contra SQL Injection para o Banco
    $termo = $conn->real_escape_string($_GET['busca']);
    $filtro_sql = "WHERE nome LIKE '%$termo%' OR email LIKE '%$termo%'";
    
    // Mantém o texto limpo para mostrar no Input (sem as barras invertidas)
    $busca = $_GET['busca'];
}

$sql = "SELECT * FROM alunos $filtro_sql ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Alunos</title>
    <style>
        :root {
            --primary: #4a90e2;
            --danger: #e74c3c;
            --warning: #f1c40f;
            --bg: #f4f6f9;
            --card-bg: #ffffff;
            --text: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* --- HEADER E BARRA DE PESQUISA --- */
        .header-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        h1 { margin: 0; font-size: 1.5rem; color: #333; }

        .search-wrapper {
            display: flex;
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-wrapper input {
            width: 100%;
            padding: 12px 15px;
            padding-right: 45px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-wrapper input:focus { border-color: var(--primary); }

        .search-wrapper button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .btn-novo {
            background-color: var(--primary);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(74, 144, 226, 0.3);
            transition: transform 0.2s;
            display: inline-block;
        }

        .btn-novo:hover { transform: translateY(-2px); }

        /* --- TABELA RESPONSIVA --- */
        .table-container {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 15px;
            font-weight: 600;
            color: #7f8c8d;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* Foto Avatar */
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
        }

        /* --- BOTÕES DE AÇÃO --- */
        .actions {
            display: flex;
            gap: 8px;
            justify-content: flex-start; /* Alinha à esquerda */
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
            font-size: 1.1rem;
        }

        .btn-edit { background-color: #fff3cd; color: #856404; }
        .btn-edit:hover { background-color: var(--warning); color: white; }

        .btn-delete { background-color: #f8d7da; color: #721c24; }
        .btn-delete:hover { background-color: var(--danger); color: white; }

        /* --- RESPONSIVIDADE (MOBILE CARD VIEW) --- */
        @media (max-width: 768px) {
            .header-toolbar { flex-direction: column; align-items: stretch; }
            .search-wrapper { max-width: 100%; }
            .btn-novo { text-align: center; }

            /* O Segredo: Esconde o cabeçalho da tabela */
            thead { display: none; }

            /* Transforma a tabela em blocos */
            table, tbody, tr, td { display: block; width: 100%; box-sizing: border-box;}

            tr {
                margin-bottom: 15px;
                background: white;
                border-bottom: 2px solid #eee;
                padding: 15px;
            }

            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 10px 0;
                border: none;
                border-bottom: 1px dashed #eee;
            }

            td:last-child { border-bottom: none; }

            /* Adiciona o rótulo antes do valor (Ex: Nome: Jeferson) */
            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #7f8c8d;
                text-transform: uppercase;
                font-size: 0.75rem;
                margin-right: 15px;
            }

            .actions { justify-content: flex-end; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header-toolbar">
            <h1>🎓 Alunos</h1>
            
            <form class="search-wrapper" method="GET">
                <input type="text" name="busca" placeholder="Pesquisar por nome ou email..." value="<?php echo $busca; ?>">
                <button type="submit">🔍</button>
            </form>

            <a href="cadastro.php" class="btn-novo">+ Novo Aluno</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="80">Foto</th>
                        <th width="50">ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th width="120">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            
                            $caminho_foto = "imagens/" . $row['foto'];
                            if (empty($row['foto']) || !file_exists($caminho_foto)) {
                                $caminho_foto = "https://cdn-icons-png.flaticon.com/512/149/149071.png";
                            }

                            echo "<tr>";
                            // data-label é usado pelo CSS no celular para saber o que escrever
                            echo "<td data-label='Foto'><img src='$caminho_foto' class='avatar'></td>";
                            echo "<td data-label='ID'>#" . $row['id'] . "</td>";
                            echo "<td data-label='Nome'><strong>" . $row['nome'] . "</strong></td>";
                            echo "<td data-label='Email'>" . $row['email'] . "</td>";
                            
                            echo "<td data-label='Ações'>";
                            echo "<div class='actions'>";
                            echo "<a href='editar.php?id=".$row['id']."' class='btn-action btn-edit' title='Editar'>✏️</a>";
                            echo "<a href='excluir.php?id=".$row['id']."' class='btn-action btn-delete' onclick='return confirm(\"Excluir este aluno?\")' title='Excluir'>🗑️</a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center; padding: 40px; color: #999;'>Nenhum aluno encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>