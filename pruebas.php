<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "guiltybit");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}else{
    echo "Bieeen\n";
    $mysqli->real_query("SELECT * FROM redactor");
    $resultado = $mysqli->use_result();

    print_r($resultado);
    echo "Orden del conjunto de resultados...\n";
    while ($fila = $resultado->fetch_assoc()) {
        print_r($fila);
    }
}
echo $mysqli->host_info . "\n";
?>