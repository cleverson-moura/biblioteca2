<?php 
require("../conexao.php");
?>


<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Turma</title>
</head>
<body>
    <form action="turma.php" method="post">
        DESCRIÇÃO: <input type="text" name="descricao" id="descricao" placeholder="EX: 2 Informática"><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
<?php
//INSERT
if(isset($_POST['descricao'])){    //verificar se clicou no botão
        $descricao = $_POST['descricao'];
    if (!empty($descricao)) {  //verificar se algum campo está vazio
        $res = $pdo->prepare("SELECT codigo FROM turma WHERE descricao = :d");
        $res->bindparam(":d", $descricao);
        $res->execute();
        if ($res->rowCount() > 0) {     //verificar se ja tem algun livro cadastrado
            echo "Turma já cadastrada";
        } else {
            $res = $pdo->prepare("INSERT INTO turma(descricao) VALUES (:d)");
            $res->bindparam(":d", $descricao);
            $res->execute();
        }
    }else {
        echo "preencha todos os campos";
    }
}

$resultado = $pdo->query("SELECT codigo, descricao FROM turma");
?>
<table BORDER="1">
    <tr>
        <td>CODIGO</td>
        <td>TURMA</td>
    </tr>

<?php 
while($linha = $resultado->fetch(PDO::FETCH_ASSOC)){?>
    <tr>
        <td><?php echo "{$linha['codigo']}";?> </td>
        <td><?php echo "{$linha['descricao']}";?> </td>
         <td>Editar</td>
         <td><a href="turma.php?cod=<?php echo "{$linha['codigo']}";?>">Excluir</a></td>
    </tr>
  <?php  
}
?>

</table>
<?php
if (isset($_GET['cod'])) {
    $cod_excluir = $_GET["cod"];
    $sql = $pdo->prepare("DELETE FROM turma WHERE codigo = :codigo");
    $sql->bindparam(":codigo",$cod_excluir);
    $sql->execute();
    echo "Excluido com sucesso";
    header("location: turma.php");
    }
?>