<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $tipo_doc = $_POST['tipo_doc'];
    $documento = $_POST['documento'];
    $razao = $_POST['razao'];
    $telefone = $_POST['telefone'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];

    // Criar CSV em memória
    $csv = "Nome;Tipo Documento;Documento;Razão Social;Telefone;WhatsApp;Email\n";
    $csv .= "$nome;$tipo_doc;$documento;$razao;$telefone;$whatsapp;$email\n";

    $boundary = md5(time());

    $headers = "From: Formulário <no-reply@seusite.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";

    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message .= "Dados enviados pelo formulário:\n\n";
    $message .= "Nome: $nome\n";
    $message .= "Documento: $tipo_doc - $documento\n";
    $message .= "Razão Social: $razao\n";
    $message .= "Telefone: $telefone\n";
    $message .= "WhatsApp: $whatsapp\n";
    $message .= "Email: $email\n\n";

    $message .= "--$boundary\r\n";
    $message .= "Content-Type: text/csv; name=\"dados.csv\"\r\n";
    $message .= "Content-Disposition: attachment; filename=\"dados.csv\"\r\n\r\n";
    $message .= $csv."\r\n";
    $message .= "--$boundary--";

    mail("daniel@oxsswagon.com.br", "Novo contato - Fale Conosco", $message, $headers);

    echo "<script>alert('Mensagem enviada com sucesso!');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fale Conosco</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
form {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    max-width: 420px;
    width: 100%;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
input, select, button {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
}
button {
    background: #203a43;
    color: #fff;
    border: none;
    cursor: pointer;
}
button:hover {
    background: #2c5364;
}
</style>

<script>
function validarDocumento() {
    let doc = document.getElementById("documento").value.replace(/\D/g,'');
    let tipo = document.getElementById("tipo_doc").value;

    if (tipo === "CPF" && doc.length !== 11) {
        alert("CPF inválido");
        return false;
    }
    if (tipo === "CNPJ" && doc.length !== 14) {
        alert("CNPJ inválido");
        return false;
    }
    return true;
}
</script>

</head>

<body>

<form method="post" onsubmit="return validarDocumento()">
    <h2>Fale Conosco</h2>

    <input type="text" name="nome" placeholder="Nome" required>

    <select name="tipo_doc" id="tipo_doc" required>
        <option value="CPF">CPF</option>
        <option value="CNPJ">CNPJ</option>
    </select>

    <input type="text" id="documento" name="documento" placeholder="CPF ou CNPJ" required>

    <input type="text" name="razao" placeholder="Razão Social">

    <input type="tel" name="telefone" placeholder="Telefone" required>

    <input type="tel" name="whatsapp" placeholder="WhatsApp" required>

    <input type="email" name="email" placeholder="E-mail" required>

    <button type="submit">Enviar</button>
</form>

</body>
</html>
