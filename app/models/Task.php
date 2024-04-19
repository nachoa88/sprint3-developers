<?php
require_once '../config/db.inc.php';

class Task
{
    private $mongodb;
    private $collection;

    private $id;
    private $name;
    private $status;
    private $dateTimeStarted;
    private $dateTimeFinished;
    private $user;

    public function __construct()
    {
        $db = new Db();
        $this->mongodb = $db->getConnection();
        $this->collection = $db->getConnection()->tasks;
    }

    // CRUD Logic
    public function getAllTasks()
    {
        $cursor = $this->collection->find([]);
        return $cursor;
    }

    public function getTaskById($id)
    {
        $cursor = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        return $cursor;
    }

    public function createTask()
    {
        // Prepare statement
        $name = $this->name;
        $status = $this->status;
        $dateTimeStarted = $this->dateTimeStarted;
        $dateTimeFinished = $this->dateTimeFinished;
        $user = $this->user;

        $this->collection->insertOne([
            'name' => $name,
            'status' => $status,
            'dateTimeStarted' => $dateTimeStarted,
            'dateTimeFinished' => $dateTimeFinished,
            'user' => $user,
        ]);

        // After form is validated and processed, we want to redirect to index.
        return header('Location: index');
    }

    public function updateTask(string $id, array $newData)
    {
        // Prepare the filter
        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

        // Prepare the update operation
        $update = [
            '$set' => [
                'name' => $newData['name'],
                'status' => $newData['status'],
                'dateTimeStarted' => $newData['dateTimeStarted'],
                'dateTimeFinished' => $newData['dateTimeFinished'],
                'user' => $newData['user'],
            ]
        ];

        // Update the document
        $this->collection->updateOne($filter, $update);

        // After form is validated and processed, we want to redirect to index.
        return header('Location: index');
    }

    public function deleteTask($id)
    {
        $filter = ['_id' => $id];
        $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

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
