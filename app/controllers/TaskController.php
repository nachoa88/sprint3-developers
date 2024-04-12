<?php

class TaskController extends Controller
{
    private bool $validateForm;

	public function setValidateForm($validateForm)
	{
		$this->validateForm = $validateForm;

		return $this;
	}

    
    public function indexAction()
    {
        // Get all tasks and display them
        $taskModel = new Task();
        $this->view->message = $taskModel->getAllTasks();
    }

    public function createTaskAction()
    {
        // The method check if form is sent.
        // If the form is sent, the method call to the createTask method of the model, witch process the form.
        // If it's not, it's just call to createtask view witch contains the form.
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $taskModel = new Task();
            $taskModel->createTask();

            // After form is validated and processed, we want to redirect to index.
            // If form is not validated the createtask view is called again.
            if ($taskModel->validateForm($_POST)) {
                return header('Location: index');
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

            // Redirect to index after the model does its work
            return header('Location: index');
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
}
