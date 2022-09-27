<?php 
require("../conexao.php");
?>


<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <form action="usuario.php" method="post">
        NOME: <input type="text" name="nome" id="nome"><br>
        SOBRENOME: <input type="text" name="sobrenome" id="sobrenome"><br>
        EMAIL: <input type="email" name="email" id="email"><br>
        SENHA: <input type="text" name="senha" id="senha" maxlength="32"><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
<?php
//INSERT
if(isset($_POST['nome'])){    //verificar se clicou no botão
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);
    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($senha)) {  //verificar se algum campo está vazio
        $res = $pdo->prepare("SELECT codigo FROM usuario WHERE email = :e");
        $res->bindparam(":e", $email);
        $res->execute();
        if ($res->rowCount() > 0) {     //verificar se ja tem algun livro cadastrado
            echo "Usuario já cadastrada";
        } else {
            $res = $pdo->prepare("INSERT INTO usuario(nome, sobrenome, email, senha) VALUES (:n, :s, :e, :p)");
            $res->bindparam(":n", $nome);
            $res->bindparam(":s", $sobrenome);
            $res->bindparam(":e", $email);
            $res->bindparam(":p", $senha);
            $res->execute();
        }
    }else {
        echo "preencha todos os campos";
    }
}

$resultado = $pdo->query("SELECT codigo, nome, sobrenome, email FROM usuario");
?>
<table BORDER="1">
    <tr>
        <td>CODIGO</td>
        <td>NOME</td>
        <td>SOBRENOME</td>
        <td>EMAIL</td>
    </tr>

<?php 
while($linha = $resultado->fetch(PDO::FETCH_ASSOC)){?>
    <tr>
        <td><?php echo "{$linha['codigo']}";?> </td>
        <td><?php echo "{$linha['nome']}";?> </td>
        <td><?php echo "{$linha['sobrenome']}";?> </td>
        <td><?php echo "{$linha['email']}";?> </td>
        <td>Excluir</td>
        <td>Editar</td>
    </tr>
  <?php  
}
?>

</table>
<?php

?>