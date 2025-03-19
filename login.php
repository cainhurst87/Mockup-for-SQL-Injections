<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
session_start();

// Conexão sem sanitização
$conn = new mysqli("localhost", "root", "", "Mockup");
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$user = $_POST['username'];
$pass = $_POST['password'];

// Query intencionalmente vulnerável
$sql = "SELECT * FROM users 
        WHERE username = '$user' 
        AND password = '$pass'";

// Exibe a query realizada no log
error_log("QUERY EXECUTADA: " . $sql);

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<script>
            alert('ACESSO PERMITIDO!\\n\\n'
                + 'ID: " . $row['id'] . "\\n'
                + 'Usuário: " . $row['username'] . "\\n'
                + 'Senha: " . $row['password'] . "');
            setTimeout(() => { location.href='index.html' }, 0);
        </script>";
} else {
    echo "<script>
            alert('ERRO: Credenciais inválidas!');
            location.href='index.html';
        </script>";
}

$conn->close();
?>