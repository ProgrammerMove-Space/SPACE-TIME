<?php
header('Content-Type: application/json');

// Configuração da base de dados
$host = 'sql308.alojamento-gratis.com';
$dbname = 'ljmn_38672788_DB_LPJ';
$username = 'ljmn_38672788';
$password = 'Matias#2024';

// Conexão à base de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => 'Erro na conexão à base de dados: ' . $conn->connect_error]));
}

// Buscar contactos da base de dados
$result = $conn->query("SELECT * FROM Contactos");

if (!$result) {
    http_response_code(500);
    die(json_encode(['error' => 'Erro na consulta: ' . $conn->error]));
}

// Preparar array com os dados
$contactos = [];
while ($row = $result->fetch_assoc()) {
    $contactos[] = [
        'telefone' => $row['num_international'] . $row['telefone'], // Adiciona prefixo +351
        'nome' => $row['nome'],
        'mensagem' => "Olá {$row['nome']}, esta é uma mensagem personalizada"
    ];
}

// Fechar conexão
$conn->close();

// Retornar os dados em formato JSON
echo json_encode([
    'success' => true,
    'count' => count($contactos),
    'contactos' => $contactos
]);
exit;
?>
