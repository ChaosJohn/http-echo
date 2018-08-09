<?php

//print_r($_REQUEST); 
//print_r($_SERVER);
//print_r($_GET);
//print_r($_POST);
//print_r($_FILES);
//print_r($_SESSION);
//print_r(getallheaders()); 

$method = $_SERVER['REQUEST_METHOD']; 
$path = $_SERVER['PATH_INFO']; 
$query = $_SERVER['QUERY_STRING']; 
$body = file_get_contents('php://input'); 
$headers = getallheaders(); 
$contentType = $_SERVER['CONTENT_TYPE']; 
$accept = $_SERVER['HTTP_ACCEPT']; 
$contentLength = $_SERVER['CONTENT_LENGTH']; 

$bodyPretty = null; 
if (false !== strpos($contentType, 'json')) { 
  // application/json
  $bodyPretty = json_decode($body); 
} else if (false !== strpos($contentType, 'x-www-form-urlencoded')){
  // application/x-www-form-urlencoded
  $bodyPretty = []; 
  $pairs = explode('&', $body); 
  foreach($pairs as $pair) {
    $elems = explode('=', $pair); 
    $key = $elems[0]; 
    $value = count($elems) > 1 ? $elems[1] : ''; 
    $bodyPretty[$key] = $value; 
  }
}

$infos = [
  'method' => $method, 
  'path' => $path, 
  'headers' => $headers, 
  'accept' => $accept, 
  'params' => $_REQUEST
]; 

if (!empty($contentType)) $infos['content-type'] = $contentType; 
if (!empty($contentLength)) $infos['content-length'] = $contentLength; 
if (!empty($body)) $infos['body'] = $body; 
if (!empty($bodyPretty)) $infos['bodyPretty'] = $bodyPretty; 
if (!empty($query)) {
  $infos['query'] = $query; 
  $queryPretty = []; 
  $pairs = explode('&', $query); 
  foreach($pairs as $pair) {
    $elems = explode('=', $pair); 
    $key = $elems[0]; 
    $value = count($elems) > 1 ? $elems[1] : ''; 
    $queryPretty[$key] = $value; 
  }
  $infos['queryPretty'] = $queryPretty; 
}

echo json_encode($infos, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES); 
