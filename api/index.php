<?php
require "../bootstrap.php";

use Src\Controller\PostController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

//pagination logic
$uri_query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
@parse_str($uri_query, $query);
$limit = isset($query['limit']) && !empty($query['limit']) ? $query['limit'] : 10;
$offset = isset($query['offset']) && !empty($query['offset']) ? $query['offset'] : 0;

// all of our endpoints start with /post
// everything else results in a 404 Not Found
if ($uri[1] !== 'post') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the post id is, of course, optional and must be a number
$postId = null;
if (isset($uri[2])) {
    $postId = (int) $uri[2];
}


$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and post ID to the PostController:
$controller = new PostController($dbConnection, $requestMethod, $postId, ['limit' => $limit, 'offset' => $offset]);
$controller->processRequest();

