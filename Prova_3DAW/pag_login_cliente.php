<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Viação Calango</title>
    <link rel="stylesheet" href="estilo_pag_login_cliente.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Viação Calango</h2>
        <form id="login-form" action="conexao.php" method="POST">
            <label for="nome">Nome de Usuário:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Validação JavaScript para exibir alerta caso usuário não exista
        <?php if(isset($_GET['erro']) && $_GET['erro'] == '1') { ?>
            alert("Usuário ou senha incorretos!");
        <?php } ?>
    </script>
</body>
</html>
