<?php

namespace app\controllers;


use app\models\Task;
use tm\libs\Pagination;

class TasksController extends Controller
{

    public function index()
    {
        $sortBy = 'performer';

        if(isset($_GET['sort_by'])){
            $sortBy = $_GET['sort_by'];
        }

        $sort = ucfirst($sortBy);

        $total = \R::count('tasks');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 3;

        $pagination = new Pagination($page, $perPage, $total);
        $start = $pagination->getStart();
        $tasks = \R::findAll( 'tasks' , 'Order By ' . $sortBy . ' LIMIT ' . $start . ', ' . $perPage );

        $this->setVars(compact('tasks', 'pagination', 'total','sort'));
        $this->view = 'index';
    }


    public function store()
    {
        $task = new Task;
        $data = $_POST;
        $data['status'] = 0;
        $task->load($data);
        if(!$task->validate($data)){
            $task->getErrors();
            redirect();
        }
        $task->save('tasks');
        $_SESSION['success'] = 'Task added successfully.';
        redirect();
    }


    public function update()
    {
        $data = $_POST;
        $task = \R::load('tasks', $data['task_id']);
        $task['status'] = $data['status'];

        if($data['description'] == ''){
            $_SESSION['error'] = 'Description is required';
            redirect();
        }
        if($task['description'] != $data['description']){
            $task['description'] = $data['description'];
            $task['edited'] = 1;
        }
        \R::store($task);
        redirect();
    }

    public function delete()
    {
        if(isset($_GET['id'])){
            \R::trash('tasks', $_GET['id']);
        }
        redirect();
    }
}