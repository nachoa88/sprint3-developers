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

    public function getTaskById()
    {
        // Implement the logic to get a task by its ID
        return "Task found";
    }

    public function createTask()
    {
        // Implement the logic to create a new task in the database

        $data = $this->getData();
        $tasks = json_decode($data, true); //decode data to an array

        // Get last id
        $last_item = end($tasks);
        $last_item_id = $last_item['id'];   

        // update id to last id + 1
        $_POST['id'] = ++$last_item_id;

        // add $_POST to $task array
        $tasks[] = $_POST;
        $jsonString = json_encode($tasks, JSON_PRETTY_PRINT);

        // write to file
        file_put_contents('../web/db/tasks.json', $jsonString, FILE_APPEND | LOCK_EX);
        // $fp = fopen('../web/db/tasks.json', 'w');
        // fwrite($fp, $jsonString);
        // fclose($fp);       
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
