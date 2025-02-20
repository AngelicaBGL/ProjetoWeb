<?php
session_start();
include 'sessao.php';

// Verifica se o usuário tem permissão para cadastrar grupos
if ($_SESSION['usuario_perfil'] !== 'admin') {
    echo "Acesso negado!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];

    // Validação básica dos dados
    if (empty($nome)) {
        echo "O nome do grupo é obrigatório!";
        exit();
    }

    // Conecta ao banco de dados
    $conn = new mysqli("localhost", "root", "", "bprural");
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Prepara a query para inserir o grupo
    $sql = "INSERT INTO grupos (nome) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);

    // Executa a query
    if ($stmt->execute()) {
        echo "Grupo cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar grupo: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}
?>