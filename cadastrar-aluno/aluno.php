<?php 
require("../conexao.php");
?>


<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
</head>
<body>
    <form action="aluno.php" method="post">
        MATRICULA: <input type="number" name="matricula" id="matricula"><br>
        NOME: <input type="text" name="nome" id="nome"><br>
        SOBRENOME: <input type="text" name="sobrenome" id="sobrenome"><br>
        TELEFONE: <input type="number" name="telefone" id="telefone"><br>
        EMAIL: <input type="email" name="email" id="email"><br>

        <select name="turma" id="turma">
            <option value="" selected>Selecione...</option>
            <?php 
            $resTurma = $pdo->query("SELECT codigo, descricao FROM turma");
            while($op = $resTurma->fetch(PDO::FETCH_ASSOC)){?>
                    <option value="<?php echo "{$op['codigo']}";?>"><?php echo "{$op['descricao']}";?></option>
                    
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

if(isset($_POST['nome'])){    //verificar se clicou no botão
        $matricula = $_POST['matricula'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $turma = $_POST['turma'];
    if (!empty($matricula) && !empty($nome) && !empty($sobrenome) && !empty($telefone) && !empty($email)) {  //verificar se algum campo está vazio
        $res = $pdo->prepare("SELECT nome FROM aluno WHERE matricula = :m");
        $res->bindparam(":m", $matricula);
        $res->execute();
        if ($res->rowCount() > 0) {     //verificar se ja tem algun livro cadastrado
            echo "aluno já cadastrado";
        } else {
            $res = $pdo->prepare("INSERT INTO aluno(matricula, nome, sobrenome, telefone, email, turma) VALUES (:matricula, :nome, :sobrenome, :telefone, :email, :turma)");
            $res->bindparam(":matricula", $matricula);
            $res->bindparam(":nome", $nome);
            $res->bindparam(":sobrenome", $sobrenome);
            $res->bindparam(":telefone", $telefone);
            $res->bindparam(":email", $email);
            $res->bindparam(":turma", $turma);
            $res->execute();
        }
    }else {
        echo "preencha todos os campos";
    }
    echo $matricula;
}
?>