<?php

ini_set('display_errors', 1);
error_reporting(-1);

header("Content-type: application/json; charset=UTF-8");


function exception_handler($exception) {
    echo "Uncaught exception: " , $exception->getMessage(), "\n";
}

set_exception_handler('exception_handler');

// db
// $dbh = new PDO('mysql:host=localhost;dbname=taskmanager', 'root', '');
$dbh = new PDO('mysql:host=us-cdbr-iron-east-02.cleardb.net;dbname=heroku_7b1e58f0aeabc7b', 'ba6f36888dde7f', '1784d694');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$postData = json_decode(file_get_contents('php://input'), true);

if ($_GET){



    switch($_GET['action']) {
        case 'addProject':
            $stm = $dbh->query("INSERT INTO projects (name) VALUES ('')");
            echo $dbh->lastInsertId();
            return true;

        case 'removeProject':
            $stm = $dbh->prepare("DELETE FROM projects WHERE id=?");
            $stm->execute(array($postData['id']));
            $stm = $dbh->prepare("DELETE FROM tasks WHERE project_id=?");
            $stm->execute(array($postData['id']));
            return true;

        case 'addTask':
            $name = '';
            if (isset($postData['name']))
                $name = $postData['name'];
            $stm = $dbh->prepare("INSERT INTO tasks (name, project_id) VALUES (?,?)");
            $stm->execute(array($name, $postData['id']));
            echo $dbh->lastInsertId();
            return true;

        case 'removeTask':
            $stm = $dbh->prepare("DELETE FROM tasks WHERE id=?");
            $stm->execute(array($postData['id']));
            return true;

    }
}

$stm = $dbh->query('SELECT * from projects');
$projects = $stm->fetchAll();
$projectIds = array();
foreach($projects as $project)
    $projectIds[] = $project->id;

$placeholders = rtrim(str_repeat('?, ', count($projectIds)), ', ') ;
$query = "SELECT * from tasks WHERE project_id IN ($placeholders)";
$stm = $dbh->prepare($query) ;
$stm->execute($projectIds);
$tasks = $stm->fetchAll();

foreach ($projects as &$project)
{
    $project->tasks = array();
    foreach($tasks as $key=>$task)
    {
        if ($task->project_id == $project->id)
        {
            $project->tasks[] = $task;
            unset($tasks[$key]);
        }
    }
}

echo json_encode($projects);

$dbh = null;
