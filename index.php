<?php

if (!function_exists('getallheaders')) {
	function getallheaders() {
		$headers = [];
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}

//print_r($_REQUEST); 
//print_r($_SERVER);
//print_r($_GET);
//print_r($_POST);
//print_r($_FILES);
//print_r($_SESSION);
//print_r(getallheaders()); 

$method = $_SERVER['REQUEST_METHOD']; 
$path = $_SERVER['PATH_INFO']; 
$requestUri = $_SERVER['REQUEST_URI']; 
$query = $_SERVER['QUERY_STRING']; 
$body = file_get_contents('php://input'); 
$headers = getallheaders(); 
$contentType = $_SERVER['CONTENT_TYPE']; 
$accept = $_SERVER['HTTP_ACCEPT']; 
$contentLength = $_SERVER['CONTENT_LENGTH']; 

if (empty($path) && !empty($requestUri)) {
  if (0 === strpos($requestUri, '/')) $requestUri = substr($requestUri, 1); 
  $requestUriSplits = explode('?', $requestUri); 
  $path = $requestUriSplits[0]; 
  if (empty($query) && count($requestUriSplits) > 0) $query = str_replace($path.'?', '', $requestUri); 
}

$infos = [
  'method' => $method, 
  'path' => $path, 
  'headers' => $headers, 
  'accept' => $accept, 
  'params' => $_REQUEST
]; 

$bodyPretty = null; 
if (false !== strpos($contentType, 'json')) { 
  // application/json
  $bodyPretty = json_decode($body, true); 
  $infos['params'] = array_merge($infos['params'], $bodyPretty); 
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
  $infos['params'] = array_merge($infos['params'], $queryPretty); 
}

echo json_encode($infos, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES); 
