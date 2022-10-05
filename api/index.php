<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';
require 'db.php';
$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/todo', function (Request $request, Response $response, $args) {
    $sql = "SELECT * FROM todo";

    try {
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

$app->post('/todo', function (Request $request, Response $response, array $args) {
    // $response->getBody()->write("this is post user....");
    // $id = $_POST["id"];
    $username = $_POST["username"];
    $task = $_POST["task"];
    $status = $_POST["status"];
    $target = $_POST["target"];


    try {
        $sql = "INSERT INTO todo (username, task, status, target) 
        VALUES (:username, :task, :status, :target)";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':id', $id);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':task', $task);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':target', $target);

        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;

        $data = array(
            "status" => "success",
            "rowcount" => $count
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($e);
    }
});
$app->delete('/todo/{task_id}', function (Request $request, Response $response, array $args) {
    // $id = $args['id'];
    // $response->getBody()->write("this is delete user id....: $id");
    // return $response;
    $id = $args['task_id'];

    try {
        $sql = "DELETE FROM todo WHERE id = $id";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;

        $data = array(
            "rowAffected" => $count,
            "status" => "success"
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

$app->post('/register', function (Request $request, Response $response, array $args) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $re_password = $_POST["re_password"];
    $is_admin = $_POST["is_admin"];

    if ($password != $re_password) {
        echo ("Password does not match! Please reenter!");
    } else {
        try {
            $sql = "INSERT INTO users (username, email, password, is_admin) 
            VALUES (:username, :email, :password, :is_admin)";
            $db = new db();
            // Connect
            $db = $db->connect();
            $stmt = $db->prepare($sql);

            $hashpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $hashpassword);
            $stmt->bindValue(':is_admin', $is_admin);

            $stmt->execute();
            $count = $stmt->rowCount();
            $db = null;

            $data = array(
                "status" => "success",
                "rowcount" => $count
            );
            echo json_encode($data);
        } catch (PDOException $e) {
            $data = array(
                "status" => "fail"
            );
            echo json_encode($e);
        }
    }
});

$app->get('/login/{username}&{password}', function (Request $request, Response $response, $args) {
    $username = $args['username'];
    $password = md5($args['password']);
    $sql = "SELECT * FROM users WHERE username = $username";

    try {
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($stmt->rowCount() > 0) {
            $_SESSION['login'] = $username;
            header("location:add.html");
        } else {
            echo "<script>alert('Invalid Details');</script>";
        }
        $db = null;
        echo json_encode($user);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});




$app->run();
