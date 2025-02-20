<?php
session_start();
include 'sessao.php';

if ($_SESSION['usuario_perfil'] !== 'admin') {
    echo "Acesso negado!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];

    $conn = new mysqli("localhost", "root", "", "bprural");

    $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $senha, $perfil);

    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário.";
    }

    $stmt->close();
    $conn->close();
}
?>