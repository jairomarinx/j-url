<?php
include 'conf.php';

function is_valid_url($url): bool
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

$url="";

if (!isset($_GET['password']))
{
    echo "Missing Password"; 
    return;
}

if ($_GET['password'] != $api_password )
{
    echo "Wrong Password";
    return;
}

if (!isset($_GET['url']))
{
    echo "Missing Url to save";
    return;
}else
{
    $url = $_GET['url'];
}

if (!is_valid_url($url))
{
    echo "Url is not valid";
    return;
}

$db = new PDO('sqlite:sqlite.db');
$rst = $db->query("Select max(id) from urls");

$next_id = (int) $rst->fetchColumn() ? $rst->fetchColumn()+1 : 1; 
$short_code = (string) dechex($next_id);

$rst = $db->prepare("Insert into urls(id, short_code, long_url) values(:id, :short_code, :long_url ) ");
$rst->execute([
    ':id' => $next_id,
    ':short_code' => $short_code,
    ':long_url' => $url
]);

echo "http://url.jairomarin.com/".$short_code;


