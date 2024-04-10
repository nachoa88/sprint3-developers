<?php

class TaskController extends Controller
{
    public function indexAction() {
        // Get all tasks and display them
        $taskModel = new Task();
        $this->view->message = $taskModel->getAllTasks();
    }

    public function createTaskAction() {
        // Show the form for creating a new task

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $taskModel = new Task();
            $taskModel->createTask();

            // Redirect to index after the model does its work
            return header('Location: index');
        }
    }

    public function readTaskAction() {
        // Show a single task
        $taskModel = new Task(); 
        $this->view->message = $taskModel->getAllTasks();
    }

    public function updateTaskAction() {
        // Process the form for updating a task
        $taskModel = new Task(); 
        $this->view->message = $taskModel->updateTask();
    }

    public function deleteTaskAction() {
        // Delete a task
        $taskModel = new Task(); 
        $this->view->message = $taskModel->deleteTask();
    }
}