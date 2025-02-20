<?php
session_start();
include 'sessao.php';

// Verifica se o usuário tem permissão para excluir grupos
if ($_SESSION['usuario_perfil'] !== 'admin') {
    echo "Acesso negado!";
    exit();
}

// Verifica se o ID do grupo foi passado na URL
if (!isset($_GET['id'])) {
    echo "ID do grupo não especificado!";
    exit();
}

$id = $_GET['id'];

// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "", "bprural");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o grupo está associado a algum produto
$sql = "SELECT COUNT(*) as total FROM produtos WHERE grupo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['total'] > 0) {
    echo "Este grupo está associado a produtos e não pode ser excluído!";
    exit();
}

// Prepara a query para excluir o grupo
$sql = "DELETE FROM grupos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

// Executa a query
if ($stmt->execute()) {
    echo "Grupo excluído com sucesso!";
} else {
    echo "Erro ao excluir grupo: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();

// Redireciona de volta para a página de relatórios
header("Location: ../relatorio.php?tipo=grupos");
exit();
?>