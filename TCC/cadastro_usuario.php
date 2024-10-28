<?php
session_start(); // Iniciar sessão para armazenar mensagens
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obtenha os dados do formulário
        $senha = $_POST['password'];
        $senha2 = $_POST['Confirmpassword'];
        $cep = $_POST['cep'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['number'];

        // Verifica se as senhas são iguais
        if ($senha !== $senha2) {
            $_SESSION['message'] = "As senhas devem ser iguais.";
            header("Location: cadastro_geral.html");
            exit;
        }

        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepare e execute a inserção do endereço
        $query_endereco = "INSERT INTO TB_endereco (end_cep, end_estado, end_cidade, end_bairro, end_logradouro, end_numero) 
                           VALUES (:cep, :estado, :cidade, :bairro, :logradouro, :numero)";
        $stmt_endereco = $conn->prepare($query_endereco);
        $stmt_endereco->execute([
            ':cep' => $cep,
            ':estado' => $estado,
            ':cidade' => $cidade,
            ':bairro' => $bairro,
            ':logradouro' => $logradouro,
            ':numero' => $numero
        ]);

        $usu_end_codigo = $conn->lastInsertId(); // Obtém o ID do endereço inserido

        // Prepare e execute a inserção do usuário
        $query_usuario = "INSERT INTO TB_usuario (usu_nome, usu_cpf, usu_telefone, usu_email, usu_senha, usu_end_codigo) 
                          VALUES (:nome, :cpf, :telefone, :email, :senha, :usu_end_codigo)";
        $stmt_usuario = $conn->prepare($query_usuario);
        $stmt_usuario->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':telefone' => $telefone,
            ':email' => $email,
            ':senha' => $senhaHash, // Use a senha hash
            ':usu_end_codigo' => $usu_end_codigo
        ]);

        $_SESSION['message'] = "Usuário inserido com sucesso. ID: " . $conn->lastInsertId();
        header("Location: index.html");
        exit;

    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro: " . $e->getMessage();
        header("Location: cadastro_geral.html");
        exit;
    }
}

// Fecha a conexão
$conn = null;
?>
