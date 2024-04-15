<?php

class TaskController extends Controller
{

    private array $validatedData = [];

    public function indexAction()
    {
        // Get all tasks and display them
        $taskModel = new Task();
        $this->view->message = $taskModel->getAllTasks();
    }

    public function createTaskAction()
    {
        // Instanciate the model and pass the createTask method to the view
        $taskModel = new Task();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->validateForm($_POST)) {

                $taskModel->setName($this->validatedData['name']);
                $taskModel->setStatus($this->validatedData['status']);
                $taskModel->setDateTimeStarted($this->validatedData['dateTimeStarted']);
                $taskModel->setDateTimeFinished($this->validatedData['dateTimeFinished']);
                $taskModel->setUser($this->validatedData['user']);

                $this->view->message = $taskModel->createTask();
            }
        }
    }

    public function readTaskAction()
    {
        // Show a single task
        $taskModel = new Task();
        $this->view->message = $taskModel->getAllTasks();
    }

    public function updateTaskAction()
    {
        // Get ID from request, it's stored from the form in the index view.
        $id = $_POST['id'];

        // Create Task model
        $taskModel = new Task();
        // As this method is handling both the initial display of the form and the form submission,
        // we need to check if the form has been submitted or not before proceeding.
        // The form has been submitted if the request contains a 'name' parameter (or any other parameter that is required for the task)
        if (!empty($_POST['name'])) {
            // Get new data for task from request
            $newData = [
                'name' => $_POST['name'],
                'status' => $_POST['status'],
                'dateTimeStarted' => $_POST['dateTimeStarted'],
                'dateTimeFinished' => $_POST['dateTimeFinished'],
                'user' => $_POST['user'],
            ];
            // Update task data.
            $this->view->taskData = $taskModel->updateTask($id, $newData);
        } else {
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
        // $name = $status = $dateTimeStarted = $dateTimeFinished = $user = "";

        $name = $this->sanitize($form['name']);
        $status = $this->sanitize($form['status']);
        $dateTimeStarted = $this->sanitize($form['dateTimeStarted']);
        $dateTimeFinished = $this->sanitize($form['dateTimeFinished']);
        $user = $this->sanitize($form['user']);

        // Validate that name is not empty
        $nameErr = "";
        if ($name == "") {
            $nameErr = "Task no puede estar vacio" . "<br>";
        }

        // Validate that start date is anterior to finish date
        $dateErr = "";
        if ($dateTimeStarted && $dateTimeFinished < $dateTimeStarted) {
            $dateErr = "La fecha de finalización es anterior a la fecha de principio" . "<br>";
        }

        // Validate that user is not empty
        $userErr = "";
        if ($user == "") {
            $userErr = "User no puede estar vacio" . "<br>";
        }

        if ($nameErr != "" || $dateErr != "" || $userErr != "") {
            echo "<b>Error:</b>" . "<br>";
            echo $nameErr;
            echo $dateErr;
            echo $userErr;
            echo "<br>";
        } else {
            $this->validatedData['name'] = $name;
            $this->validatedData['status'] = $status;
            $this->validatedData['dateTimeStarted'] = $dateTimeStarted;
            $this->validatedData['dateTimeFinished'] = $dateTimeFinished;
            $this->validatedData['user'] = $user;

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
