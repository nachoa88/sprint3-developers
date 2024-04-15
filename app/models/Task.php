<?php

class Task
{
    private int $id;
    private string $name;
    private string $status;
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

    // CRUD Logic
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
        // Get last id
        $data = $this->getData();
        $tasks = json_decode($data, true);
        $last_item = end($tasks);
        $this->id = ++$last_item['id'];

        // Append model attributes to tasks array
        // update id to last id + 1
        $tasks[] = [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'dateTimeStarted' => $this->dateTimeStarted,
            'dateTimeFinished' => $this->dateTimeFinished,
            'user' => $this->user
        ];

        // Encode tasks
        $jsonString = json_encode($tasks, JSON_PRETTY_PRINT);

        // write to file
        file_put_contents('../web/db/tasks.json', $jsonString, LOCK_EX);

        // After form is validated and processed, we want to redirect to index.
        return header('Location: index');
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

        // Encode tasks
        $jsonString = json_encode($tasks, JSON_PRETTY_PRINT);

        // Write tasks back to JSON file
        file_put_contents('../web/db/tasks.json', $jsonString, LOCK_EX);

        // After form is validated and processed, we want to redirect to index.
        return header('Location: index');
    }

    public function deleteTask()
    {
        // Implement the logic to delete a task from the database
        return "Task deleted";
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getDateTimeStarted()
    {
        return $this->dateTimeStarted;
    }

    public function setDateTimeStarted($dateTimeStarted)
    {
        $this->dateTimeStarted = $dateTimeStarted;

        return $this;
    }

    public function getDateTimeFinished()
    {
        return $this->dateTimeFinished;
    }

    public function setDateTimeFinished($dateTimeFinished)
    {
        $this->dateTimeFinished = $dateTimeFinished;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
