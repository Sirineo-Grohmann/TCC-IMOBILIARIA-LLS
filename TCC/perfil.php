<?php
include_once("conexao.php");
session_start();

try {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];

    // Busca os dados do usuário
    $query_usuario = "SELECT * FROM TB_usuario WHERE cod_usuario = :usuario_id";
    $stmt_usuario = $conn->prepare($query_usuario);
    $stmt_usuario->execute([':usuario_id' => $usuario_id]);
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "Usuário não encontrado.";
        exit();
    }

    // Busca o endereço relacionado
    $query_endereco = "SELECT * FROM TB_endereco WHERE cod_endereco = :endereco_id";
    $stmt_endereco = $conn->prepare($query_endereco);
    $stmt_endereco->execute([':endereco_id' => $usuario['usu_end_codigo']]);
    $endereco = $stmt_endereco->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuário</title>
</head>
<body>
    <h1>Perfil de Usuário</h1>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['usu_nome']); ?></p>
    <p><strong>CPF:</strong> <?php echo htmlspecialchars($usuario['usu_cpf']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['usu_email']); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($usuario['usu_telefone']); ?></p>
    <p><strong>Endereço:</strong></p>
    <?php
    if ($endereco) {
        echo "<p><strong>Logradouro:</strong> " . htmlspecialchars($endereco['end_logradouro']) . "</p>";
        echo "<p><strong>Bairro:</strong> " . htmlspecialchars($endereco['end_bairro']) . "</p>";
        echo "<p><strong>Cidade:</strong> " . htmlspecialchars($endereco['end_cidade']) . "</p>";
        echo "<p><strong>Estado:</strong> " . htmlspecialchars($endereco['end_estado']) . "</p>";
        echo "<p><strong>CEP:</strong> " . htmlspecialchars($endereco['end_cep']) . "</p>";
    } else {
        echo "<p>Endereço não encontrado.</p>";
    }
    ?>
</body>
</html>