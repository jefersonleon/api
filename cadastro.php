<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Aluno</title>
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
            min-height: 100vh;
        }

        .container {
            background: var(--card-bg);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: var(--primary);
            font-size: 1.8rem;
        }

        /* Ícone de Novo Usuário (Para combinar com o Editar) */
        .img-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .icon-new {
            width: 100px;
            height: 100px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary);
            border: 4px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

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
            box-sizing: border-box;
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

        /* Grupo de Botões (Igual ao Editar) */
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-direction: column;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: var(--success); /* Verde para cadastro */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #218838;
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

        @media (min-width: 600px) {
            .btn-group {
                flex-direction: row;
            }
            button, .btn-cancel {
                width: 50%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="img-container">
        <div class="icon-new">+</div>
    </div>
    
    <h2>Novo Aluno</h2>
    
    <form action="salvar_alunos.php" method="POST" enctype="multipart/form-data">
        
        <label>Nome Completo</label>
        <input type="text" name="nome" required placeholder="Ex: Jeferson Leon">

        <label>E-mail</label>
        <input type="email" name="email" required placeholder="Ex: email@teste.com">

        <label>Foto de Perfil</label>
        <input type="file" name="arquivo_foto" accept="image/*">

        <div class="btn-group">
            <a href="index.php" class="btn-cancel">Cancelar</a>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</div>

</body>
</html>