<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "imobiliaria_lls";

try {
    // Criando uma nova instância de PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão com o banco de dados realizada com sucesso."; // Para testes
} catch (PDOException $err) {
    // Exibindo mensagem de erro
    die("Erro: conexão com o banco de dados não realizada com sucesso. Erro gerado: " . $err->getMessage());
}
?>