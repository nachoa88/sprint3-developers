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

    public function getData()
    {
        $filename = '../web/db/tasks.json';
        $data = file_get_contents($filename); //data read from json file
        return $data;
    }

    // CRUD
    public function getAllTasks(): array
    {
        // Implement the logic to get all tasks
        $data = $this->getData();
        $tasks = json_decode($data, true); //decode data to an array

        return $tasks;
    }

    public function getTaskById(int $id)
    {
        // Read tasks from JSON file
        $data = $this->getData();
        $tasks = json_decode($data, true);

        // Find task with given ID
        foreach ($tasks as $task) {
            if ($task['id'] === $id) {
                // If found, return and exits function. (return always exists the current function)
                return $task;
            }
        }

        // Return null if task not found
        return null;
    }

    public function createTask()
    {
        // Implement the logic to create a new task in the database
        return "Task created";
    }

    public function updateTask(int $id, array $newData)
    {
        // Read tasks from JSON file
        $data = $this->getData();
        $tasks = json_decode($data, true);
        
        // Find task with given ID and update its data
        $updatedTask = null;
        // In PHP, foreach operates on a copy of the array, so we need to use 
        // a reference to update the original array, this is done by using the & operator.
        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                $task = array_merge($task, $newData);
                $updatedTask = $task;
                break;
            }
        }

        // Write tasks back to JSON file
        file_put_contents('../web/db/tasks.json', json_encode($tasks));

        return $updatedTask;
    }

    public function deleteTask()
    {
        // Implement the logic to delete a task from the database
        return "Task deleted";
    }
}
