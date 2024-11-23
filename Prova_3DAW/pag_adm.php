<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Ônibus e Funcionários</title>
    <link rel="stylesheet" href="estilo_pag_adm.css">
</head>
<body>
    <div class="container">
        <div class="section" id="gerenciar-onibus">
            <h2>Gerenciar Ônibus</h2>
            <div id="onibus-list"></div>
            <button onclick="window.location.href='Crud_Onibus.php'">Gerenciar Ônibus</button>
        </div>
        <div class="section" id="gerenciar-funcionarios">
            <h2>Gerenciar Funcionários</h2>
            <div id="funcionarios-list"></div>
            <button onclick="window.location.href='Crud_Funcionarios.php'">Gerenciar Funcionários</button>
        </div>
    </div>

    <script>
        // Aqui pode-se adicionar interatividade com JavaScript para exibir dados dinamicamente.
    </script>
</body>
</html>