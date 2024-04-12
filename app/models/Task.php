<?php

class Task
{
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
        $data = $this->getData();
        // Decode data to an array
        $tasks = json_decode($data, true);

        // We validate that start date is anterior to finish date.
        if ($_POST['dateTimeFinished'] && $_POST['dateTimeFinished'] < $_POST['dateTimeStarted']) {
            // If not, validation is set to false.
            $_SESSION['validateForm'] = false;
            echo "¡La fecha de finalización es anterior a la fecha de principio!";
        } else {
            // If validated, we set the flag true and proceed.
            $_SESSION['validateForm'] = true;
            // Get last id
            $last_item = end($tasks);
            $last_item_id = $last_item['id'];

            // update id to last id + 1
            $_POST['id'] = ++$last_item_id;

            // Add $_POST to $task array
            $tasks[] = $_POST;
            $jsonString = json_encode($tasks, JSON_PRETTY_PRINT);

            // write to file
            file_put_contents('../web/db/tasks.json', $jsonString, LOCK_EX);

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
}
