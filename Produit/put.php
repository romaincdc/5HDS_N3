<?php
$url = "http://127.0.0.1:8888/5HDS_N3/Produit/produits/2"; 
$data = array('id' =>'2', 'name' => 'MC', 'description' => 'Ordinateur portable', 'price' => '9658', 'stock' => '2', 'reference' => 'ARTBIUSJDK');

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