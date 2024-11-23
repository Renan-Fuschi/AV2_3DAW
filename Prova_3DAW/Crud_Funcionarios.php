<?php
$servername = "localhost";
$username = "meu_usuario";
$password = "minha_senha";
$dbname = "sistema_gerenciamento";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Operações AJAX (para evitar recarregamento da página)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $nome = $_POST['nome'];
        $codigo = $_POST['codigo'];
        $funcao = $_POST['funcao'];
        $sql = "INSERT INTO funcionarios (nome, codigo, funcao) VALUES ('$nome', '$codigo', '$funcao')";
        $conn->query($sql);
        echo json_encode(["status" => "success", "message" => "Funcionário adicionado com sucesso!"]);
        exit;
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $codigo = $_POST['codigo'];
        $funcao = $_POST['funcao'];
        $sql = "UPDATE funcionarios SET nome='$nome', codigo='$codigo', funcao='$funcao' WHERE id=$id";
        $conn->query($sql);
        echo json_encode(["status" => "success", "message" => "Funcionário atualizado com sucesso!"]);
        exit;
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $sql = "DELETE FROM funcionarios WHERE id=$id";
        $conn->query($sql);
        echo json_encode(["status" => "success", "message" => "Funcionário excluído com sucesso!"]);
        exit;
    }
}

// Buscar todos os funcionários
$result = $conn->query("SELECT * FROM funcionarios");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Funcionários</title>
    <link rel="stylesheet" href="estilo_Crud.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Gerenciar Funcionários</h2>
    <form id="create-form">
        <input type="text" id="nome" placeholder="Nome do funcionário" required>
        <input type="text" id="codigo" placeholder="Código do funcionário" required>
        <input type="text" id="funcao" placeholder="Função" required>
        <button type="submit">Adicionar</button>
    </form>
    <ul id="funcionarios-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li data-id="<?php echo $row['id']; ?>">
                <span class="nome"><?php echo $row['nome']; ?></span> -
                <span class="codigo"><?php echo $row['codigo']; ?></span> -
                <span class="funcao"><?php echo $row['funcao']; ?></span>
                <button class="edit-btn">Editar</button>
                <button class="delete-btn">Excluir</button>
            </li>
        <?php endwhile; ?>
    </ul>

    <script>
        $(document).ready(function() {
            // Criar novo funcionário
            $("#create-form").submit(function(event) {
                event.preventDefault();
                const nome = $("#nome").val();
                const codigo = $("#codigo").val();
                const funcao = $("#funcao").val();

                $.post("crudFunc.php", {
                    action: "create",
                    nome: nome,
                    codigo: codigo,
                    funcao: funcao
                }, function(response) {
                    const data = JSON.parse(response);
                    alert(data.message);
                    if (data.status === "success") {
                        location.reload();
                    }
                });
            });

            // Editar funcionário
            $(".edit-btn").click(function() {
                const li = $(this).closest("li");
                const id = li.data("id");
                const nome = prompt("Nome:", li.find(".nome").text());
                const codigo = prompt("Código:", li.find(".codigo").text());
                const funcao = prompt("Função:", li.find(".funcao").text());

                if (nome && codigo && funcao) {
                    $.post("crudFunc.php", {
                        action: "update",
                        id: id,
                        nome: nome,
                        codigo: codigo,
                        funcao: funcao
                    }, function(response) {
                        const data = JSON.parse(response);
                        alert(data.message);
                        if (data.status === "success") {
                            location.reload();
                        }
                    });
                }
            });

            // Excluir funcionário
            $(".delete-btn").click(function() {
                if (confirm("Tem certeza que deseja excluir este funcionário?")) {
                    const li = $(this).closest("li");
                    const id = li.data("id");

                    $.post("crudFunc.php", {
                        action: "delete",
                        id: id
                    }, function(response) {
                        const data = JSON.parse(response);
                        alert(data.message);
                        if (data.status === "success") {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>