<?php
session_start();
include 'sessao.php';

// Verifica se o tipo de relatório foi passado na URL
if (!isset($_GET['tipo'])) {
    echo "Tipo de relatório não especificado!";
    exit();
}

$tipo = $_GET['tipo'];

// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "", "bprural");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Define a query com base no tipo de relatório
switch ($tipo) {
    case 'usuarios':
        $sql = "SELECT id, nome, email, perfil FROM usuarios";
        $titulo = "Relatório de Usuários";
        break;
    case 'grupos':
        $sql = "SELECT id, nome FROM grupos";
        $titulo = "Relatório de Grupos";
        break;
    case 'produtos':
        $sql = "SELECT p.id, p.nome, p.descricao, p.preco, g.nome as grupo_nome 
                FROM produtos p 
                LEFT JOIN grupos g ON p.grupo_id = g.id";
        $titulo = "Relatório de Produtos";
        break;
    default:
        echo "Tipo de relatório inválido!";
        exit();
}

// Executa a query
$result = $conn->query($sql);

if (!$result) {
    echo "Erro ao buscar dados: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1><?php echo $titulo; ?></h1>
        <nav>
            <ul>
                <li><a href="../relatorio.html">Voltar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <?php
                    // Exibe os cabeçalhos da tabela
                    $fields = $result->fetch_fields();
                    foreach ($fields as $field) {
                        echo "<th>{$field->name}</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Exibe os dados da tabela
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>{$value}</td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='" . count($fields) . "'>Nenhum dado encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>