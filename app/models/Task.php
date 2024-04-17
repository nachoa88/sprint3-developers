<?php
require_once '../config/db.inc.php';

class Task
{
    private $mysqli;

    private int $id;
    private $name;
    private $status;
    private $dateTimeStarted;
    private $dateTimeFinished;
    private $user;

    public function __construct()
    {
        $db = new Db();
        $this->mysqli = $db->getConnection();
    }

    // CRUD Logic
    public function getAllTasks()
    {
        $query = "SELECT * FROM task";
        $result = $this->mysqli->query($query);
        return $result;
    }

    public function getTaskById(int $id)
    {
        $query = "SELECT * FROM task WHERE id = $id";
        $result = $this->mysqli->query($query);

        $task = $result->fetch_assoc();
        return $task;
    }

    public function createTask()
    {
        // Prepare statement, stage 1: prepare
        $sql = "INSERT INTO task(`name`, `status`, dateTimeStarted, dateTimeFinished, user) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);

        // Prepare statement, stage 2: bind and execute
        $name = $this->name;
        $status = $this->status;
        $dateTimeStarted = $this->dateTimeStarted;
        $dateTimeFinished = $this->dateTimeFinished;
        $user = $this->user;

        $stmt->bind_param("sssss", $name, $status, $dateTimeStarted, $dateTimeFinished, $user);
        $stmt->execute();

        // After form is validated and processed, we want to redirect to index.
        return header('Location: index');
    }

    public function updateTask(int $id, array $newData)
    {
        // Prepare statement, stage 1: prepare
        $sql = "UPDATE task SET `name` = ?, `status` = ?, dateTimeStarted = ?, dateTimeFinished = ?, user = ? WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);

        // Prepare statement, stage 2: bind and execute
        $id = $id;
        $name = $this->name;
        $status = $this->status;
        $dateTimeStarted = $this->dateTimeStarted;
        $dateTimeFinished = $this->dateTimeFinished;
        $user = $this->user;

        $stmt->bind_param("sssssi", $name, $status, $dateTimeStarted, $dateTimeFinished, $user, $id);
        $stmt->execute();

        // After form is validated and processed, we want to redirect to index.
        return header('Location: index');
    }

    public function deleteTask(int $id)
    {
        $query = "DELETE FROM task WHERE id = $id";
        $this->mysqli->query($query);

        // Return to to index
        return header('Location: index');
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
