<?php
declare(strict_types=1);

$dominio ='mysql:host=localhost;dbname=banco_ong';
$usuario ='root';
$senha='1234';

try{
    $pdo = new PDO($dominio, $usuario, $senha);

}catch(PDOException $e){
     die("Erro ao conectar com o banco!".$e->getMessage());
}

?>