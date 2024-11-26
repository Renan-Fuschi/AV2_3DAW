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
$conn->set_charset("utf8mb4");

// Operações AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $salario = $_POST['salario'];

        $stmt = $conn->prepare("INSERT INTO funcionarios (codigo, nome, cargo, salario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $codigo, $nome, $cargo, $salario);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Funcionário adicionado com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao adicionar funcionário."]);
        }
        exit;
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $salario = $_POST['salario'];

        $stmt = $conn->prepare("UPDATE funcionarios SET codigo = ?, nome = ?, cargo = ?, salario = ? WHERE id = ?");
        $stmt->bind_param("sssdi", $codigo, $nome, $cargo, $salario, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Funcionário atualizado com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao atualizar funcionário."]);
        }
        exit;
    } elseif ($action === 'delete') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM funcionarios WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Funcionário excluído com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao excluir funcionário."]);
        }
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
    <h2 style="color:white">Gerenciar Funcionários</h2>
    <form id="create-form">
        <input type="text" id="codigo" placeholder="Código do funcionário" required>
        <input type="text" id="nome" placeholder="Nome do funcionário" required>
        <input type="text" id="cargo" placeholder="Cargo" required>
        <input type="number" id="salario" placeholder="Salário" required step="0.01">
        <button type="submit">Adicionar</button>
    </form>
    <ul id="funcionarios-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li data-id="<?php echo $row['id']; ?>">
                <span class="codigo"><?php echo $row['codigo']; ?></span> -
                <span class="nome"><?php echo $row['nome']; ?></span> -
                <span class="cargo"><?php echo $row['cargo']; ?></span> -
                <span class="salario">R$ <?php echo number_format($row['salario'], 2, ',', '.'); ?></span>
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
                const codigo = $("#codigo").val();
                const nome = $("#nome").val();
                const cargo = $("#cargo").val();
                const salario = $("#salario").val();

                $.post("Crud_Funcionarios.php", {
                    action: "create",
                    codigo: codigo,
                    nome: nome,
                    cargo: cargo,
                    salario: salario
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
                const codigo = prompt("Código do funcionário:", li.find(".codigo").text());
                const nome = prompt("Nome do funcionário:", li.find(".nome").text());
                const cargo = prompt("Cargo:", li.find(".cargo").text());
                const salario = prompt("Salário:", li.find(".salario").text().replace("R$ ", "").replace(",", "."));

                if (codigo && nome && cargo && salario) {
                    $.post("Crud_Funcionarios.php", {
                        action: "update",
                        id: id,
                        codigo: codigo,
                        nome: nome,
                        cargo: cargo,
                        salario: salario
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

                    $.post("Crud_Funcionarios.php", {
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
