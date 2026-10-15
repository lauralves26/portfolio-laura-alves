<?php

require "conexao.php";

$id = $_GET["id"];

$sql = "SELECT * FROM mensagens WHERE id = ?";

$stmt = $conexao->prepare($sql);
$stmt->execute([$id]);

$mensagem = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensagem) {
    die("Mensagem não encontrada.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>Editar Mensagem</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="container">

        <h1>Editar Mensagem</h1>

        <form action="editar.php?id=<?php echo $id; ?>" method="POST">

            <label>Nome:</label>

            <input
                type="text"
                name="nome"
                value="<?php echo htmlspecialchars($mensagem['nome']); ?>"
                required
            >

            <label>E-mail:</label>

            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($mensagem['email']); ?>"
                required
            >

            <label>Mensagem:</label>

            <textarea name="mensagem" required><?php
                echo htmlspecialchars($mensagem['mensagem']);
            ?></textarea>

            <button type="submit" name="atualizar">
                Salvar alterações
            </button>

        </form>

        <a href="mensagens.php">Voltar</a>

    </div>

</body>

</html>

<?php

if (isset($_POST["atualizar"])) {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $texto = trim($_POST["mensagem"]);

    if ($nome == "" || $email == "" || $texto == "") {
        die("Preencha todos os campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Digite um e-mail válido.");
    }

    $sql = "UPDATE mensagens
            SET nome = ?, email = ?, mensagem = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        $nome,
        $email,
        $texto,
        $id
    ]);

    header("Location: mensagens.php");
    exit;
}

?>