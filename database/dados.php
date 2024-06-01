<?php 
// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos obrigatórios foram preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['telefone']) && !empty($_POST['genero']) && !empty($_POST['data_nascimento']) && !empty($_POST['cidade']) && !empty($_POST['estado'])) {
        
        // dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $genero = $_POST['genero'];
        $data_nascimento = $_POST['data_nascimento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $data_atual = date('Y-m-d'); // Alterei o formato da data para o padrão do MySQL
        $hora_atual = date('H:i:s');

        // credenciais
        $server = 'localhost';
        $usuario = 'root';
        $senha = '';
        $banco = 'projeto_formulario';

        // conexão banco de dados
        $conn = new mysqli($server, $usuario, $senha, $banco);

        // verificar conexão
        if($conn->connect_error){
            die("falha ao se comunicar com banco de dados: ".$conn->connect_error);
        }

        $smtp = $conn->prepare("INSERT INTO informações (nome, email, telefone, genero, data_nascimento, cidade, estado, data, hora) VALUES(?,?,?,?,?,?,?,?,?)");
        $smtp->bind_param("ssissssss", $nome, $email, $telefone, $genero, $data_nascimento, $cidade, $estado, $data_atual, $hora_atual); // Alterei $data para $data_atual

        if($smtp->execute()){
            echo "Dados enviados com sucesso!";
        }
        else{
            echo "Erro no envio dos dados ".$smtp->error;
        }

        $smtp->close();
        $conn->close();
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos!";
    }
} else {
    echo "Este script só pode ser acessado via método POST!";
}
?>
