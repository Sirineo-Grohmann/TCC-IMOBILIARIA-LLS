<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se imagens foram enviadas
    if (isset($_FILES['imagem'])) {
        $pasta = "uploads/";

        // Coleta os dados do imóvel
        $desc_basica = $_POST['desc_basica'];
        $valor = $_POST['valor'];
        $comodos = $_POST['comodos'];
        $tamanho = $_POST['tamanho'];
        $desc_completa = $_POST['desc_completa'];
        $cep = $_POST['cep'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];

        // Inserção do imóvel
        $query_imoveis = "INSERT INTO TB_imovel (imo_desc_basica, imo_valor, imo_numero_comodos, imo_tamanho_imovel, imo_desc_completa) 
                          VALUES (:desc_basica, :valor, :comodos, :tamanho, :desc_completa)";
        $stmt_imoveis = $conn->prepare($query_imoveis);

        if ($stmt_imoveis->execute([
            ':desc_basica' => $desc_basica,
            ':valor' => $valor,
            ':comodos' => $comodos,
            ':tamanho' => $tamanho,
            ':desc_completa' => $desc_completa
        ])) {
            $cod_imovel = $conn->lastInsertId(); // Obtém o ID do imóvel inserido

            // Processa cada imagem enviada
            foreach ($_FILES['imagem']['tmp_name'] as $key => $tmp_name) {
                $nomeImg = $_FILES['imagem']['name'][$key];
                $extensao = strtolower(pathinfo($nomeImg, PATHINFO_EXTENSION));

                if ($extensao != "jpg" && $extensao != "png") {
                    echo "Tipo de arquivo não aceito: $nomeImg.<br>";
                    continue; // Pula para a próxima imagem
                }

                $novonomeImg = uniqid();
                $caminho = $pasta . $novonomeImg . "." . $extensao;

                // Move o arquivo para a pasta de uploads
                if (move_uploaded_file($tmp_name, $caminho)) {
                    // Insere a imagem no banco de dados
                    $query_imagem = "INSERT INTO TB_imagens (img_nome) VALUES (:caminho)";
                    $stmt_imagem = $conn->prepare($query_imagem);
                    if ($stmt_imagem->execute([':caminho' => $caminho])) {
                        $cod_imagem = $conn->lastInsertId(); // Armazena o ID da imagem

                        // Insere na tabela de junção
                        $query_juncao = "INSERT INTO TB_imagem_imovel (junt_img_imovel, junt_img_imagem) VALUES (:id_imovel, :id_imagem)";
                        $stmt_juncao = $conn->prepare($query_juncao);
                        if ($stmt_juncao->execute([
                            ':id_imovel' => $cod_imovel,
                            ':id_imagem' => $cod_imagem
                        ])) {
                            echo "Imagem $nomeImg associada ao imóvel com sucesso.<br>";
                        } else {
                            echo "Falha ao associar a imagem $nomeImg ao imóvel: " . implode(", ", $stmt_juncao->errorInfo()) . "<br>";
                        }
                    } else {
                        echo "Falha ao cadastrar a imagem $nomeImg: " . implode(", ", $stmt_imagem->errorInfo()) . "<br>";
                    }
                } else {
                    echo "Erro ao mover o arquivo $nomeImg para a pasta de uploads.<br>";
                }
            }

            // Inserção do endereço
            $query_endereco = "INSERT INTO TB_endereco (end_cep, end_estado, end_cidade, end_bairro, end_logradouro, end_numero) 
                               VALUES (:cep, :estado, :cidade, :bairro, :logradouro, :numero)";
            $stmt_endereco = $conn->prepare($query_endereco);

            if ($stmt_endereco->execute([
                ':cep' => $cep,
                ':estado' => $estado,
                ':cidade' => $cidade,
                ':bairro' => $bairro,
                ':logradouro' => $logradouro,
                ':numero' => $numero
            ])) {
                $cod_endereco = $conn->lastInsertId(); // Obtém o ID do endereço inserido

                // Atualiza o imóvel para associá-lo ao endereço
                $query_update = "UPDATE TB_imovel SET imo_end_codigo = :id_endereco WHERE cod_imovel = :id_imovel";
                $stmt_update = $conn->prepare($query_update);
                if ($stmt_update->execute([
                    ':id_endereco' => $cod_endereco,
                    ':id_imovel' => $cod_imovel
                ])) {
                    echo "Endereço associado ao imóvel com sucesso.";
                } else {
                    echo "Falha ao associar o endereço ao imóvel: " . implode(", ", $stmt_update->errorInfo());
                }
            } else {
                echo "Falha ao cadastrar o endereço: " . implode(", ", $stmt_endereco->errorInfo());
            }
        } else {
            echo "Falha ao cadastrar o imóvel: " . implode(", ", $stmt_imoveis->errorInfo());
        }
    } else {
        echo "Erro no upload da imagem.";
    }
}

$conn = null;
?>
