<?php

require "conexao.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM mensagens WHERE id = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->execute([$id]);

}

header("Location: mensagens.php");

exit;

?>