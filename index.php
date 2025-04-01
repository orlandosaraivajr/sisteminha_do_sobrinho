<?php
// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$password = "senha_secreta";
$dbname = "biblioteca";
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criar a tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS livro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    editora VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NOT NULL
)";
$conn->query($sql);

// CRUD
if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    if ($acao == "inserir") {
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $isbn = $_POST['isbn'];
        $sql = "INSERT INTO livro (titulo, autor, editora, isbn) VALUES ('$titulo', '$autor', '$editora', '$isbn')";
        $conn->query($sql);
    } elseif ($acao == "deletar") {
        $id = $_POST['id'];
        $sql = "DELETE FROM livro WHERE id = '$id'";
        $conn->query($sql);
    }
}

$livros = $conn->query("SELECT * FROM livro");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Gerenciamento de Livros</h2>
    
    <form method="POST" class="mb-3">
        <input type="hidden" name="acao" value="inserir">
        <div class="mb-3">
            <label>Título do Livro</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Autor</label>
            <input type="text" name="autor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Editora</label>
            <input type="text" name="editora" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Livro</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Editora</th>
                <th>ISBN</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($livro = $livros->fetch_assoc()) { ?>
                <tr>
                    <td><?= $livro['id'] ?></td>
                    <td><?= $livro['titulo'] ?></td>
                    <td><?= $livro['autor'] ?></td>
                    <td><?= $livro['editora'] ?></td>
                    <td><?= $livro['isbn'] ?></td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="id" value="<?= $livro['id'] ?>">
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
