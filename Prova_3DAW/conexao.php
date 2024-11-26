<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_gerenciamento";  // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para verificar o nome de usuário e senha
    $sql = "SELECT * FROM usuarios WHERE nome = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o usuário for encontrado, redireciona para a página principal
        $_SESSION['usuario'] = $nome;  // Armazena o nome do usuário na sessão
        header("Location: pag_cliente.html");  // Redireciona para a página principal
        exit();
    } else {
        // Se o usuário não for encontrado, exibe uma mensagem de erro
        header("Location: index.html?erro=1");
        exit();
    }
}
?>