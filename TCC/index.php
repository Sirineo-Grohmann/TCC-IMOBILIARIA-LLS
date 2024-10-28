<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobilíaria</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pesquisa.css">
    <link rel="stylesheet" href="css/icones_compra_favorito.css">
</head>
<body>
    <header class="cabecalho">
        <div class="principal">
            <img class="logo" src="Imagens/logo.jpg" alt="logo de uma casa">
            <h1>Imobilíaria LLS</h1>
            <a class="login" href="login.html">Login</a>
        </div>
        <nav class="navegacao">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastro_imovel.html">Anuncie seu Imóvel!</a></li>
                <li><a href="cadastro_geral.html">Cadastre-se!</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="sobre_nos.html">Sobre nós</a></li>
            </ul>
        </nav>
        <div class="pesquisa_caixa">
            <input type="text" id="pesquisa" placeholder="Pesquisa" class="pesquisa_texto">
            <a href="#" class="pesquisa_botao">
                <img id="lupa" src="Imagens/loupe.png" alt="Lupa">
            </a>
        </div>
    </header>
    <main>
            <div id="produto">
            <?php include 'loopImoveis.php'; ?>
        </div>
    </main>
    <footer>
        <img class="logo" src="Imagens/logo.jpg" alt="Logo da Imobiliária">
        <p class="copyright">&copy; Copyright LLS Imobilhária - 2024</p>
    </footer>
</body>
</html>
