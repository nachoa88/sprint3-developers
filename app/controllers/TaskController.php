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

                // If data if validated we prepare the date
                $preparedData = $this->prepareDate($validatedData);

                // Instanciate the model
                $taskModel = new Task();

                // Pass prepared data to the model
                $taskModel->setName($preparedData['name']);
                $taskModel->setStatus($preparedData['status']);
                $taskModel->setDateTimeStarted($preparedData['dateTimeStarted']);
                $taskModel->setDateTimeFinished($preparedData['dateTimeFinished']);
                $taskModel->setUser($preparedData['user']);

                // Call the method
                $this->view->message = $taskModel->createTask();
            }
        }
    }

    public function updateTaskAction()
    {
        // Instanciate the model
        $taskModel = new Task();
        // Get ID from request, it's stored from the form button in the index view.
        $taskId = $_POST['id'];
        // We get the document by id
        $taskById = $taskModel->getTaskById($taskId);
        $this->view->taskData = $taskModel->getTaskById($taskId);

        // If form is sent, validate data
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateButton'])) {
            // Get ID from the submitted form, in the update view (hidden input field)
            $id = $_POST['id'];
            // Check if data is validated and retrieves $validatedData array
            if ($validatedData = $this->validateForm($_POST)) {

                // If data if validated we prepare the date
                $preparedData = $this->prepareDate($validatedData);

                // Pass prepared data to the model
                $taskModel->setName($preparedData['name']);
                $taskModel->setStatus($preparedData['status']);
                $taskModel->setDateTimeStarted($preparedData['dateTimeStarted']);
                $taskModel->setDateTimeFinished($preparedData['dateTimeFinished']);
                $taskModel->setUser($preparedData['user']);

                // Update task data.
                $this->view->taskData = $taskModel->updateTask($id, $preparedData);
            }
        }
    }

    public function deleteTaskAction()
    {
        // Get ID from request
        $id = $_POST['id'];

        // Delete Task model
        $taskModel = new Task();
        $this->view->message = $taskModel->deleteTask($id);
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
        if ($name == null) {
            $nameErr = "Task can't be empty. ";
        }

        // Validate that start date is anterior to finish date
        $dateErr = "";
        if ($dateTimeStarted && $dateTimeFinished < $dateTimeStarted && $dateTimeFinished != null) {
            $dateErr = "Finish time is before start time. ";
        }

        // Validate that user is not empty
        $userErr = "";
        if ($user == null) {
            $userErr = "User can't be empty. ";
        }

        if ($nameErr != "" || $dateErr != "" || $userErr != "") {
            // Display errors
            echo "<div class='flex items-center justify-center text-white bg-red-700'>Error: ";
            echo $nameErr;
            echo $dateErr;
            echo $userErr;
            echo "</div>";
            return false;
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

    public function sanitize($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        // If form return empty string, convert to null value to match BSON field types
        if ($data == '') {
            $data = null;
        }
        return $data;
    }

    // If date is null we pass the null value to mongodb
    // If date exist, convert date strings to MongoDB\BSON\UTCDateTime objects
    // getTimestamp * 1000 because MongoDB\BSON\UTCDateTime expects milliseconds
    public function prepareDate($document)
    {
        if ($document['dateTimeStarted']) {
            $dateTimeStarted = new DateTime($document['dateTimeStarted']);
            $document['dateTimeStarted'] = new MongoDB\BSON\UTCDateTime($dateTimeStarted->getTimestamp() * 1000);
        }

        if ($document['dateTimeFinished']) {
            $dateTimeFinished = new DateTime($document['dateTimeFinished']);
            $document['dateTimeFinished'] = new MongoDB\BSON\UTCDateTime($dateTimeFinished->getTimestamp() * 1000);
        }
        return $document;
    }
}
