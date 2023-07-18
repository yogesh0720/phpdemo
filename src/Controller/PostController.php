<?php

namespace Src\Controller;

ini_set('memory_limit', '-1');

use Src\Model\PostModel;

class PostController
{
    private $db;
    private $requestMethod;
    private $postId;

    private $postModel;

    public function __construct($db, $requestMethod, $postId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->postId = $postId;

        $this->postModel = new PostModel($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->postId) {
                    $response = $this->getPost($this->postId);
                } else {
                    $response = $this->getAllPosts();
                };
                break;
            case 'POST':
                $response = $this->createPostFromRequest();
                break;
            case 'PUT':
                $response = $this->updatePostFromRequest($this->postId);
                break;
            case 'DELETE':
                $response = $this->deletePost($this->postId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllPosts()
    {
        $result = $this->postModel->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getPost($id)
    {
        $result = $this->postModel->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createPostFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validatePost($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->postModel->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = 'Inserted successfully';
        return $response;
    }

    private function updatePostFromRequest($id)
    {
        $result = $this->postModel->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        var_dump($input);
        die;
        if (!$this->validatePost($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->postModel->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = 'Updated successfully';
        return $response;
    }

    private function deletePost($id)
    {
        $result = $this->postModel->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->postModel->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = 'Deleted successfully';
        return $response;
    }

    private function validatePost($input)
    {
        if (!isset($input['title'])) {
            return false;
        }
        if (!isset($input['body'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = 'Not found';
        return $response;
    }
}
