<?php

enum Status
{
    case Pending;
    case InProgress;
    case Finished;
}

class Task
{
    private int $id;
    private string $name;
    private Status $status;
    private string $dateTimeStarted;
    private string $dateTimeFinished;
    private string $user;

    private string $filename;
    private string $data;
    private array $tasks;

    public function __construct()
    {
        $this->filename = '../web/db/tasks.json';
        $this->data = file_get_contents($this->filename); //data read from json file
        $this->tasks = json_decode($this->data); //decode data
    }

    // CRUD
    public function getAllTasks():array
    {
        // Implement the logic to get all tasks
        return $this->tasks;
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
