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
    private Status $status;
    private string $dateTimeStarted;
    private string $dateTimeFinished;
    private string $user;

    public function __construct()
    {
    }

    // CRUD
    public function getAllTasks()
    {
        // Implement the logic
        return "Showing all tasks";
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
