<?php 
require("../conexao.php");
?>


<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livro</title>
</head>
<body>
    <form action="livro.php" method="post">
        CODIGO: <input type="number" name="codigo" id="codigo"><br>
        TITULO: <input type="text" name="titulo" id="titulo"><br>
        QUANTIDADE DE PAGINAS: <input type="number" name="paginas" id="paginas"><br>
        
        <select name="autor" id="autor">
            <option value="" selected>Selecione...</option>
            <?php 
            $resAutor = $pdo->query("SELECT codigo, nome FROM autor");
            while($op = $resAutor->fetch(PDO::FETCH_ASSOC)){?>
                    <option value="<?php echo "{$op['codigo']}";?>"><?php echo "{$op['nome']}";?></option>
                    
              <?php  
            }
            
            ?>
        </select><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
<?php
//INSERT

if(isset($_POST['titulo'])){    //verificar se clicou no botão
        $codigo = $_POST['codigo'];
        $titulo = $_POST['titulo'];
        $paginas = $_POST['paginas'];
        $autor = $_POST['autor'];
    if (!empty($codigo) && !empty($paginas) && !empty($autor)) {  //verificar se algum campo está vazio
        $res = $pdo->prepare("SELECT codigo FROM livro WHERE titulo = :t");
        $res->bindparam(":t", $titulo);
        $res->execute();
        if ($res->rowCount() > 0) {     //verificar se ja tem algun livro cadastrado
            echo "livro já cadastrado";
        } else {
            $res = $pdo->prepare("INSERT INTO livro(codigo, titulo, quantidade, autor) VALUES (:codigo, :titulo, :paginas, :autor)");
            $res->bindparam(":codigo", $codigo);
            $res->bindparam(":titulo", $titulo);
            $res->bindparam(":paginas", $paginas);
            $res->bindparam(":autor", $autor);
            $res->execute();
        }
    }else {
        echo "preencha todos os campos";
    }
}

$resultado = $pdo->query("SELECT codigo, titulo, quantidade, autor FROM livro ORDER BY titulo");
?>
<table BORDER="1">
    <tr>
        <td>CODIGO</td>
        <td>TÍTULO</td>
        <td>PÁGINAS</td>
        <td>AUTOR</td>
    </tr>

<?php 
while($linha = $resultado->fetch(PDO::FETCH_ASSOC)){?>
    <tr>
        <td><?php echo "{$linha['codigo']}";?> </td>
        <td><?php echo "{$linha['titulo']}";?> </td>
        <td><?php echo "{$linha['quantidade']}";?> </td>
        <td><?php echo "{$linha['autor']}";?> </td>
        <td>Editar</td>
        <td><a href="livro.php?cod=<?php echo "{$linha['codigo']}";?>">Excluir</a></td>
    </tr>
  <?php  
}
?>

</table>
<?php
if (isset($_GET['cod'])) {
    $cod_excluir = $_GET["cod"];
    $sql = $pdo->prepare("DELETE FROM livro WHERE codigo = :codigo");
    $sql->bindparam(":codigo",$cod_excluir);
    $sql->execute();
    echo "Excluido com suces";
    header("location: livro.php");
}
?>