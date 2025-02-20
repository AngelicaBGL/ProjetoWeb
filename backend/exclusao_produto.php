<?php
session_start();
include 'sessao.php';

// Verifica se o usuário tem permissão para excluir produtos
if ($_SESSION['usuario_perfil'] !== 'admin') {
    echo "Acesso negado!";
    exit();
}

// Verifica se o ID do produto foi passado na URL
if (!isset($_GET['id'])) {
    echo "ID do produto não especificado!";
    exit();
}

$id = $_GET['id'];

// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "", "bprural");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Prepara a query para excluir o produto
$sql = "DELETE FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

// Executa a query
if ($stmt->execute()) {
    echo "Produto excluído com sucesso!";
} else {
    echo "Erro ao excluir produto: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();

// Redireciona de volta para a página de relatórios
header("Location: ../relatorio.php?tipo=produtos");
exit();
?>