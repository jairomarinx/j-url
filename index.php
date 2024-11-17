<?php


if (!isset($_GET['id']))
{
    echo "Wrong Url Code";
    return;
}

$id = $_GET['id'];

$db = new PDO("sqlite:sqlite.db");
$rst = $db->query("Select long_url from urls where id = :id ");
$rst->execute([
    ':id' => $id
]);
$url = $rst->fetchColumn();
header("Location: ".$url);

