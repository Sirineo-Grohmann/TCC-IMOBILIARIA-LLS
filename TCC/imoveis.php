<?php
include 'conexao.php';

// Verifica se o ID do imóvel foi passado
if (!isset($_GET['id'])) {
    die("Erro: ID do imóvel não fornecido.");
}

$cod_imovel = $_GET['id'];

// Busca as informações do imóvel e do endereço
$query_imovel = "
    SELECT i.*, e.*
    FROM TB_imovel i
    INNER JOIN TB_endereco e ON i.imo_end_codigo = e.cod_endereco
    WHERE i.cod_imovel = :id_imovel
";
$stmt_imovel = $conn->prepare($query_imovel);
$stmt_imovel->execute([':id_imovel' => $cod_imovel]);
$imovel = $stmt_imovel->fetch(PDO::FETCH_ASSOC);

// Verifica se o imóvel foi encontrado
if (!$imovel) {
    die("Erro: Imóvel não encontrado.");
}

// Busca as imagens associadas ao imóvel
$query_imagens = "
    SELECT img.img_nome 
    FROM TB_imagens img
    INNER JOIN TB_imagem_imovel ji ON img.cod_imagens = ji.junt_img_imagem 
    WHERE ji.junt_img_imovel = :id_imovel
";
$stmt_imagens = $conn->prepare($query_imagens);
$stmt_imagens->execute([':id_imovel' => $cod_imovel]);
$imagens = $stmt_imagens->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Imóvel</title>
    <link rel="stylesheet" href="css/teste.css">
</head>
<body>
    <h1>Detalhes do Imóvel</h1>

    <h2>Imagens do Imóvel</h2>

    <?php if (count($imagens) > 0): ?>
        <div>
            <?php foreach ($imagens as $imagem): ?>
                <img src="<?php echo htmlspecialchars($imagem['img_nome']); ?>" alt="Imagem do Imóvel" style="width:200px; height:auto;">
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Não há imagens disponíveis para este imóvel.</p>
    <?php endif; ?>
    <br>
    <p><?php echo htmlspecialchars($imovel['imo_desc_basica']); ?></p>

    <h2>Valor</h2>
    <p>R$ <?php echo number_format($imovel['imo_valor'], 2, ',', '.'); ?></p>

    <h2>Descrição</h2>

    <p>O imóvel contém  <?php echo htmlspecialchars($imovel['imo_numero_comodos']); ?> comodos.</p>

    <p>Tamanho do imóvel <?php echo htmlspecialchars($imovel['imo_tamanho_imovel']); ?> M²</p>

    <p><?php echo htmlspecialchars($imovel['imo_desc_completa']); ?></p>

    <h2>Endereço</h2>
    <p>
        <?php 
        echo htmlspecialchars($imovel['end_logradouro']) . ', ' . 
             htmlspecialchars($imovel['end_numero']) . ', ' . 
             htmlspecialchars($imovel['end_bairro']) . ', ' . 
             htmlspecialchars($imovel['end_cidade']) . ' - ' . 
             htmlspecialchars($imovel['end_estado']) . ' - ' . 
             htmlspecialchars($imovel['end_cep']);
        ?>
    </p>

    

    <a href="index.php">Voltar</a>
</body>
</html>

<?php
$conn = null;
?>
