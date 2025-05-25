<?php
session_start();

if (isset($_POST["btns"])) {
    include_once("code/conexao.php");

    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    $erros = [];

    // Consulta usuário pelo e-mail
    $resultado = mysqli_query($conexao, "SELECT email, senha FROM usuarios WHERE email = '$email'");

    if ($resultado && mysqli_num_rows($resultado) === 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verifica senha
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['nome'] = $usuario['nome'];
            header("Location: inipage.php");
            exit();
        } else {
            $erros[] = "E-mail ou senha incorretos.";
        }
    } else {
        $erros[] = "E-mail ou senha incorretos.";
    }

    
}
?>
