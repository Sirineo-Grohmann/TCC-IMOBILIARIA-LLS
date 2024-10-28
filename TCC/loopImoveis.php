<?php
// Conexão com o banco de dados
include 'conexao.php';

$query_imoveis = "SELECT * FROM TB_imovel";
$stmt_imoveis = $conn->prepare($query_imoveis);
$stmt_imoveis->execute();
$imoveis = $stmt_imoveis->fetchAll(PDO::FETCH_ASSOC);

if ($imoveis) {
    foreach ($imoveis as $imovel) {
        // Obter a imagem do imóvel
        $query_imagem = "SELECT img_nome FROM TB_imagem_imovel JOIN TB_imagens ON TB_imagem_imovel.junt_img_imagem = TB_imagens.cod_imagens WHERE TB_imagem_imovel.junt_img_imovel = :id_imovel";
        $stmt_imagem = $conn->prepare($query_imagem);
        $stmt_imagem->execute([':id_imovel' => $imovel['cod_imovel']]);
        $imagem = $stmt_imagem->fetch(PDO::FETCH_ASSOC);
        $imagem_url = $imagem ? $imagem['img_nome'] : 'caminho/default.jpg'; // Imagem padrão

        // Exibir os dados do imóvel com link
        echo '<a href="imoveis.php?id=' . urlencode($imovel['cod_imovel']) . '" class="produto">'; // Link corrigido
        echo '<img src="' . htmlspecialchars($imagem_url) . '" alt="Imagem do Imóvel"/>';
        echo '<p><strong>Descrição Básica:</strong> ' . htmlspecialchars($imovel['imo_desc_basica']) . '</p>';
        echo '<p><strong>Valor:</strong> R$ ' . number_format($imovel['imo_valor'], 2, ',', '.') . '</p>';
        echo '</a>'; // Fecha o link
    }
} else {
    echo '<p>Nenhum imóvel cadastrado.</p>';
}
?>

