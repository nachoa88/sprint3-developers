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
        $taskModel = new Task(); 
        $this->view->message = $taskModel->createTask();
    }

    public function readTaskAction() {
        // Show a single task
        $taskModel = new Task(); 
        $this->view->message = $taskModel->getTaskById();
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