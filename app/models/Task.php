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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // We sanitize and validate the form
            if ($this->validateForm($_POST)) {

                // Get last id
                $data = $this->getData();
                $tasks = json_decode($data, true);
                $last_item = end($tasks);
                $last_item_id = $last_item['id'];

                // update id to last id + 1
                $this->id = ++$last_item_id;

                // Add fields to $newTask array
                $newTask['id'] = $this->id;
                $newTask['name'] = $this->name;
                $newTask['status'] = $this->status;
                $newTask['dateTimeStarted'] = $this->dateTimeStarted;
                $newTask['dateTimeFinished'] = $this->dateTimeFinished;
                $newTask['user'] = $this->user;

                // Append newTask to tasks array
                $tasks[] = $newTask;

                // Encode task
                $jsonString = json_encode($tasks, JSON_PRETTY_PRINT);

                // write to file
                file_put_contents('../web/db/tasks.json', $jsonString, LOCK_EX);

                // After form is validated and processed, we want to redirect to index.
                return header('Location: index');
            }
        }
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
        file_put_contents('../web/db/tasks.json', json_encode($tasks), JSON_PRETTY_PRINT);

        return $updatedTask;
    }

    public function deleteTask()
    {
        // Implement the logic to delete a task from the database
        return "Task deleted";
    }

    public function validateForm($form)
    {
        $this->name = $this->status = $this->dateTimeStarted = $this->dateTimeFinished = $this->user = "";

        $this->name = $this->sanitize($_POST['name']);
        $this->status = $this->sanitize($_POST['status']);
        $this->dateTimeStarted = $this->sanitize($_POST['dateTimeStarted']);
        $this->dateTimeFinished = $this->sanitize($_POST['dateTimeFinished']);
        $this->user = $this->sanitize($_POST['user']);

        // Validate that name is not empty
        $nameErr = "";
        if ($this->name == "") {
            $nameErr = "Task no puede estar vacio" . "<br>";
        }

        // Validate that start date is anterior to finish date
        $dateErr = "";
        if ($this->dateTimeStarted && $this->dateTimeFinished < $this->dateTimeStarted) {
            $dateErr = "La fecha de finalización es anterior a la fecha de principio" . "<br>";
        }

        // Validate that user is not empty
        $userErr = "";
        if ($this->user == "") {
            $userErr = "User no puede estar vacio" . "<br>";
        }

        if ($nameErr != "" || $dateErr != "" || $userErr != "") {
            echo "<b>Error:</b>" . "<br>";
            echo $nameErr;
            echo $dateErr;
            echo $userErr;
            echo "<br>";
        } else {
            return true;
        }
    }

    public function sanitize($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
