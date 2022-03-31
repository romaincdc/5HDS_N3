<?php 

$url = 'http://127.0.0.1:8888/5HDS_N3/Produit/produits';
  $data = array('nom' => 'PEC', 'description' => 'Pencil 2H', 'prix' => '225', 'stock' => '9','reference' =>'JEANAIMARRE');
  
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if ($result === FALSE) { /* Handle error */ }
  var_dump($result);
?>