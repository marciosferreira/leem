<?php
// tools/benchmark_db.php

// Carrega configurações se existirem
if (file_exists(__DIR__ . '/../env_local.sh')) {
    $env = file_get_contents(__DIR__ . '/../env_local.sh');
    $lines = explode("\n", $env);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        if (strpos($line, 'export ') === 0) {
            $line = substr($line, 7);
        }
        list($key, $val) = explode('=', $line, 2);
        $val = trim($val, '"\'');
        putenv("$key=$val");
    }
}

// Configurações do Banco de Dados
$host = getenv('LEEM_DB_HOST') ?: 'localhost';
$user = getenv('LEEM_DB_USER') ?: 'root';
$pass = getenv('LEEM_DB_PASS') ?: '';
$name = getenv('LEEM_DB_NAME') ?: 'leem_db';
$port = getenv('LEEM_DB_PORT') ?: 3306;

echo "=== Iniciando Benchmark de Banco de Dados ===\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $name\n";
echo "-------------------------------------------\n";

$start_total = microtime(true);

// Teste 1: Conexão Simples
echo "1. Testando tempo de conexão...\n";
$start_conn = microtime(true);
$mysqli = new mysqli($host, $user, $pass, $name, $port);
$end_conn = microtime(true);

if ($mysqli->connect_error) {
    die("ERRO DE CONEXÃO: " . $mysqli->connect_error . "\n");
}
echo "   Tempo de conexão: " . number_format(($end_conn - $start_conn), 4) . " segundos\n";

// Teste 2: Query Simples (Ping)
echo "2. Testando query simples (SELECT 1)...\n";
$start_query = microtime(true);
$mysqli->query("SELECT 1");
$end_query = microtime(true);
echo "   Tempo da query: " . number_format(($end_query - $start_query), 4) . " segundos\n";

// Teste 3: Query Real (Tabela 'leem_materia')
echo "3. Testando query real (Tabela 'leem_materia')...\n";
$start_real = microtime(true);
$result = $mysqli->query("SELECT id, titulo FROM leem_materia LIMIT 5");
$end_real = microtime(true);

if ($result) {
    $row_count = $result->num_rows;
    echo "   Tempo da query real ($row_count linhas): " . number_format(($end_real - $start_real), 4) . " segundos\n";
    $result->free();
} else {
    echo "   Erro na query real: " . $mysqli->error . "\n";
}

$mysqli->close();

$end_total = microtime(true);
echo "-------------------------------------------\n";
echo "Tempo Total do Script: " . number_format(($end_total - $start_total), 4) . " segundos\n";
echo "=== Fim do Benchmark ===\n";
