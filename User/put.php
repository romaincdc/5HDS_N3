<?php

$url = "http://127.0.0.1:8888/5HDS_N3/User/user/3";

    $data = array('id' =>'3', 'nom' => 'Carvalho', 'prenom' => 'Romain', 'role' => 'admin'); 
    



$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

$response = curl_exec($ch);

var_dump($response);

if (!$response) 
{
    return false;
}
?>