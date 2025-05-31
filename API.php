<?php

header('Content-Type: text/html; charset=UTF-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = htmlspecialchars($_POST['nome'] ?? 'Não informado');
    $endereco = htmlspecialchars($_POST['endereco'] ?? 'Não informado');
    $cidade = htmlspecialchars($_POST['cidade'] ?? 'Não informado');
    $telefone = htmlspecialchars($_POST['telefone'] ?? 'Não informado');
    
    $data_entrega = htmlspecialchars($_POST['data-entrega'] ?? 'Não informada');
    $observacoes = htmlspecialchars($_POST['observacoes'] ?? 'Nenhuma');

    $erros = [];

    if (empty(trim($nome))) {
        $erros[] = "Nome é obrigatório.";
    }
    if (empty(trim($endereco))) {
        $erros[] = "Endereço para entrega é obrigatório.";
    }
    if (empty(trim($cidade))) {
        $erros[] = "Cidade é obrigatória.";
    }
   
    if (empty(trim($telefone)) || !preg_match('/^[0-9]{2} [0-9]{5}-[0-9]{4}$/', $telefone)) {
        $erros[] = "Telefone de contato inválido. Formato esperado: XX XXXXX-XXXX.";
    }

    
    if (empty(trim($data_entrega))) {
        $erros[] = "Prazo para entrega é obrigatório.";
    } else {
        $data_obj = DateTime::createFromFormat('Y-m-d', $data_entrega);
        
        if (!$data_obj || $data_obj->format('Y-m-d') !== $data_entrega || $data_obj < new DateTime('today')) {
            $erros[] = "Data de entrega inválida ou no passado.";
        }
    }

    
    if (!empty($erros)) {
        echo "<!DOCTYPE html>";
        echo "<html lang='pt-BR'>";
        echo "<head><meta charset='UTF-8'><title>Erro no Pedido</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #f8d7da; color: #721c24; padding: 20px; text-align: center; }";
        echo "h1 { color: #dc3545; }";
        echo "ul { list-style-type: none; padding: 0; }";
        echo "li { margin-bottom: 10px; background-color: #f5c6cb; border: 1px solid #dc3545; padding: 10px; border-radius: 5px; display: inline-block; }";
        echo "a { color: #007bff; text-decoration: none; } a:hover { text-decoration: underline; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<h1>❌ Erro no Processamento do Pedido!</h1>";
        echo "<ul>";
        foreach ($erros as $erro) {
            echo "<li>" . $erro . "</li>";
        }
        echo "</ul>";
        echo "<p><a href='index.html'>Voltar ao Formulário</a></p>";
        echo "</body>";
        echo "</html>";
    } else {
        
        echo "<!DOCTYPE html>";
        echo "<html lang='pt-BR'>";
        echo "<head><meta charset='UTF-8'><title>Pedido Recebido</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #d4edda; color: #155724; padding: 20px; text-align: center; }";
        echo "h1 { color: #28a745; }";
        echo "p { margin-bottom: 10px; line-height: 1.6; }";
        echo "strong { color: #000; }";
        echo "a { color: #007bff; text-decoration: none; } a:hover { text-decoration: underline; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<h1>✅ Pedido de Entrega Recebido com Sucesso!</h1>";
        echo "<p>Detalhes do seu pedido:</p>";
        echo "<p><strong>Nome:</strong> " . $nome . "</p>";
        echo "<p><strong>Endereço:</strong> " . $endereco . "</p>";
        echo "<p><strong>Cidade:</strong> " . $cidade . "</p>";
        echo "<p><strong>Telefone:</strong> " . $telefone . "</p>";
        echo "<p><strong>Prazo para Entrega:</strong> " . date('d/m/Y', strtotime($data_entrega)) . "</p>";
        echo "<p><strong>Observações:</strong> " . ($observacoes ? $observacoes : "Nenhuma") . "</p>";
        echo "<p>Agradecemos a sua preferência!</p>";
        echo "<p><a href='index.html'>Fazer Novo Pedido</a></p>";
        echo "</body>";
        echo "</html>";

        

} else {
   
    header('Location: index.html');
    exit();
}
?>