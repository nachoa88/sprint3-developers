<?php

enum Status
{
    case Pending;
    case InProgress;
    case Finished;
}

class Task
{
    // properties that represent the data 
    private int $id;
    private string $name;
    private Status $status;
    private string $dateTimeStarted;
    private string $dateTimeFinished;
    private string $user;

    public function __construct()
    {

    }

    public function getConnection()
    {
        $filename = '../web/db/tasks.json';
        $data = file_get_contents($filename); //data read from json file
        return $data;
    }

    // CRUD
    public function getAllTasks(): array
    {
        // Implement the logic to get all tasks
        $db = $this->getConnection();
        $result = json_decode($db); //decode data
        $tasks = $result;

        return $tasks;
    }

    public function getTaskById()
    {
        // Implement the logic to get a task by its ID
        return "Task found";
    }

    public function createTask()
    {
        // Implement the logic to create a new task in the database
        return "Task created";
    }

    public function updateTask()
    {
        // Implement the logic to update a task in the database
        return "Task updated";
    }

    public function deleteTask()
    {
        // Implement the logic to delete a task from the database
        return "Task deleted";
    }
}
