<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "imobiliaria_lls";

try {
    // Criando uma nova instância de PDO e configurando o atributo de erro
    $conn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão com o banco de dados realizada com sucesso.";
} catch (PDOException $err) {
    // Exibindo mensagem de erro
    echo "Erro: conexão com o banco de dados não realizada com sucesso. Erro gerado: " . $err->getMessage();
}
?>