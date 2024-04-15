<?php

class TaskController extends Controller
{
    public function indexAction()
    {
        // Get all tasks and display them
        $taskModel = new Task();
        $this->view->message = $taskModel->getAllTasks();
    }

    public function createTaskAction()
    {
        // If form is sent
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Check if data is validated and retrieves $validatedData array
            if ($validatedData = $this->validateForm($_POST)) {

                // Instanciate the model
                $taskModel = new Task();

                // Pass validated data to the model
                $taskModel->setName($validatedData['name']);
                $taskModel->setStatus($validatedData['status']);
                $taskModel->setDateTimeStarted($validatedData['dateTimeStarted']);
                $taskModel->setDateTimeFinished($validatedData['dateTimeFinished']);
                $taskModel->setUser($validatedData['user']);

                // Call the method
                $this->view->message = $taskModel->createTask();
            }
        }
    }

    public function updateTaskAction()
    {
        // Instanciate the model
        $taskModel = new Task();

        // If form is sent, validate data and update task.
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get ID from the submitted form, in the update view (hidden input field)
            $id = $_POST['id'];
            // Check if data is validated and retrieves $validatedData array
            if ($validatedData = $this->validateForm($_POST)) {

                // Pass validated data to the model
                $taskModel->setName($validatedData['name']);
                $taskModel->setStatus($validatedData['status']);
                $taskModel->setDateTimeStarted($validatedData['dateTimeStarted']);
                $taskModel->setDateTimeFinished($validatedData['dateTimeFinished']);
                $taskModel->setUser($validatedData['user']);

                // Update task data.
                $this->view->taskData = $taskModel->updateTask($id, $validatedData);
            }
        } else {
            // Get ID from request, it's stored from the form button in the index view.
            $id = $_GET['id'];
            // If there is no updated task, display form with current task data.
            $this->view->taskData = $taskModel->getTaskById($id);
        }
    }

    public function deleteTaskAction()
    {
        // Delete a task
        $taskModel = new Task();
        $this->view->message = $taskModel->deleteTask();
    }

    public function validateForm($form)
    {
        $validatedData = [];

        $name = $this->sanitize($form['name']);
        $status = $this->sanitize($form['status']);
        $dateTimeStarted = $this->sanitize($form['dateTimeStarted']);
        $dateTimeFinished = $this->sanitize($form['dateTimeFinished']);
        $user = $this->sanitize($form['user']);

        // Validate that name is not empty
        $nameErr = "";
        if ($name == "") {
            $nameErr = "Task can't be empty" . "<br>";
        }

        // Validate that start date is anterior to finish date
        $dateErr = "";
        if ($dateTimeStarted && $dateTimeFinished < $dateTimeStarted) {
            $dateErr = "Finish time is before start time" . "<br>";
        }

        // Validate that user is not empty
        $userErr = "";
        if ($user == "") {
            $userErr = "User can't be empty" . "<br>";
        }

        if ($nameErr != "" || $dateErr != "" || $userErr != "") {
            // Display errors
            echo "<b>Error:</b>" . "<br>";
            echo $nameErr;
            echo $dateErr;
            echo $userErr;
            echo "<br>";
        } else {
            // If no error, return an array with validated data
            $validatedData['name'] = $name;
            $validatedData['status'] = $status;
            $validatedData['dateTimeStarted'] = $dateTimeStarted;
            $validatedData['dateTimeFinished'] = $dateTimeFinished;
            $validatedData['user'] = $user;

            return $validatedData;
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
