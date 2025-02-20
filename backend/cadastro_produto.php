<?php
session_start();
include 'sessao.php';

// Verifica se o usuário tem permissão para cadastrar produtos
if ($_SESSION['usuario_perfil'] !== 'admin') {
    echo "Acesso negado!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $grupo_id = $_POST['grupo_id'];

    // Validação básica dos dados
    if (empty($nome) || empty($descricao) || empty($preco) || empty($grupo_id)) {
        echo "Todos os campos são obrigatórios!";
        exit();
    }

    // Conecta ao banco de dados
    $conn = new mysqli("localhost", "root", "", "bprural");
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Prepara a query para inserir o produto
    $sql = "INSERT INTO produtos (nome, descricao, preco, grupo_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $nome, $descricao, $preco, $grupo_id);

    // Executa a query
    if ($stmt->execute()) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}
?>
