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
        $numero = $_POST['numero'];
        $estado = $_POST['estado_atual'];

        $stmt = $conn->prepare("INSERT INTO onibus (numero, estado_atual) VALUES (?, ?)");
        $stmt->bind_param("ss", $numero, $estado);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Ônibus adicionado com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao adicionar ônibus."]);
        }
        exit;
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $numero = $_POST['numero'];
        $estado = $_POST['estado_atual'];

        $stmt = $conn->prepare("UPDATE onibus SET numero = ?, estado_atual = ? WHERE id = ?");
        $stmt->bind_param("ssi", $numero, $estado, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Ônibus atualizado com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao atualizar ônibus."]);
        }
        exit;
    } elseif ($action === 'delete') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM onibus WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Ônibus excluído com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao excluir ônibus."]);
        }
        exit;
    }
}

// Buscar todos os ônibus
$result = $conn->query("SELECT * FROM onibus");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Ônibus</title>
    <link rel="stylesheet" href="estilo_Crud.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2 style="color:white">Gerenciar Ônibus</h2>
    <form id="create-form">
        <input type="text" id="numero" placeholder="Número do ônibus" required>
        <input type="text" id="estado_atual" placeholder="Estado atual" required>
        <button type="submit">Adicionar</button>
    </form>
    <ul id="onibus-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li data-id="<?php echo $row['id']; ?>">
                <span class="numero"><?php echo $row['numero']; ?></span> -
                <span class="estado"><?php echo $row['estado_atual']; ?></span>
                <button class="edit-btn">Editar</button>
                <button class="delete-btn">Excluir</button>
            </li>
        <?php endwhile; ?>
    </ul>

    <script>
        $(document).ready(function() {
            // Criar novo ônibus
            $("#create-form").submit(function(event) {
                event.preventDefault();
                const numero = $("#numero").val();
                const estado = $("#estado_atual").val();

                $.post("Crud_Onibus.php", {
                    action: "create",
                    numero: numero,
                    estado_atual: estado
                }, function(response) {
                    const data = JSON.parse(response);
                    alert(data.message);
                    if (data.status === "success") {
                        location.reload();
                    }
                });
            });

            // Editar ônibus
            $(".edit-btn").click(function() {
                const li = $(this).closest("li");
                const id = li.data("id");
                const numero = prompt("Número do ônibus:", li.find(".numero").text());
                const estado = prompt("Estado atual:", li.find(".estado").text());

                if (numero && estado) {
                    $.post("Crud_Onibus.php", {
                        action: "update",
                        id: id,
                        numero: numero,
                        estado_atual: estado
                    }, function(response) {
                        const data = JSON.parse(response);
                        alert(data.message);
                        if (data.status === "success") {
                            location.reload();
                        }
                    });
                }
            });

            // Excluir ônibus
            $(".delete-btn").click(function() {
                if (confirm("Tem certeza que deseja excluir este ônibus?")) {
                    const li = $(this).closest("li");
                    const id = li.data("id");

                    $.post("Crud_Onibus.php", {
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
