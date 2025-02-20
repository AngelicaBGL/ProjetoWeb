<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "bprural");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$email = $_POST['email'];
$senha = $_POST['senha'];

// Verificar credenciais
$sql = "SELECT id, nome, perfil FROM usuarios WHERE email = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['usuario_id'] = $row['id'];
    $_SESSION['usuario_nome'] = $row['nome'];
    $_SESSION['usuario_perfil'] = $row['perfil'];
    header("Location: dashboard.html"); // Redirecionar para a área administrativa
} else {
    echo "Credenciais inválidas!";
}

$stmt->close();
$conn->close();
?>