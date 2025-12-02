<?php
// listar_alunos.php (WEB)

include 'conexao.php';
$sql = "SELECT * FROM alunos";
$result = $conn->query($sql);

echo "<table>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['nome'] . "</td></tr>"; // Retorna HTML
}
echo "</table>";
?>