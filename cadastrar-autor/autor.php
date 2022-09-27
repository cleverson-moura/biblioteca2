<?php 
require("../conexao.php");
?>


<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Autor</title>
</head>
<body>
    <form action="autor.php" method="post">
        NOME: <input type="text" name="nome" id="nome"><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
<?php
//INSERT
if(isset($_POST['nome'])){    //verificar se clicou no botão
        $nome = $_POST['nome'];
    if (!empty($nome)) {  //verificar se algum campo está vazio
        $res = $pdo->prepare("SELECT codigo FROM autor WHERE nome = :n");
        $res->bindparam(":n", $nome);
        $res->execute();
        if ($res->rowCount() > 0) {     //verificar se ja tem algun livro cadastrado
            echo "Autor já cadastrado";
        } else {
            $res = $pdo->prepare("INSERT INTO autor(nome) VALUES (:n)");
            $res->bindparam(":n", $nome);
            $res->execute();
        }
    }else {
        echo "preencha todos os campos";
    }
}

$resultado = $pdo->query("SELECT codigo, nome FROM autor");
?>
<table BORDER="1">
    <tr>
        <td>CODIGO</td>
        <td>AUTOR</td>
    </tr>

<?php 
while($linha = $resultado->fetch(PDO::FETCH_ASSOC)){?>
    <tr>
        <td><?php echo "{$linha['codigo']}";?> </td>
        <td><?php echo "{$linha['nome']}";?> </td>
        <td></td>
        <td><a href="autor.php?cod=<?php echo "{$linha['codigo']}";?>">Excluir</a></td>
    </tr>
  <?php  
}
?>

</table>
<?php //excluir
if (isset($_GET['cod'])) {
    $cod_excluir = $_GET["cod"];
    $sql = $pdo->prepare("DELETE FROM autor WHERE codigo = :codigo");
    $sql->bindparam(":codigo",$cod_excluir);
    $sql->execute();
    echo "Excluido com sucesso";
    header("location: autor.php");
}
?>