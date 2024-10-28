<?php
include_once("comlogin.php"); // Inclui o arquivo de conexão
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepara a consulta para verificar o usuário
    $stmt = $pdo->prepare("SELECT * FROM TB_usuario WHERE usu_email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($password, $usuario['usu_senha'])) {
        // Inicia a sessão do usuário
        $_SESSION['usuario_logado'] = $usuario['cod_usuario']; // ou qualquer outro identificador que você queira

        // Redireciona para a página principal
        header("Location: index.php");
        exit; // Para garantir que o script pare aqui
    } else {
        // Caso de erro, redireciona de volta com um parâmetro de erro
        header("Location: login.html?error=1");
        exit;
    }
}
?>
