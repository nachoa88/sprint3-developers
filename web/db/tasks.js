db.createCollection('tasks', {
    validator: {
        $jsonSchema: {
            bsonType: 'object',
            title: 'tasks',
            required: ['name', 'status', 'user'],
            properties: {
                name: {
                    bsonType: 'string'
                },
                status: {
                    bsonType: 'string',
                    enum: ['pendents', 'en execució', 'acabades']
                },
                dateTimeStarted: {
                    bsonType: ['date', 'null']
                },
                dateTimeFinished: {
                    bsonType: ['date', 'null']
                },
                user: {
                    bsonType: 'string'
                }
            }
        }
    },
    autoIndexId: true
});


// Poblate database
db.tasks.insertMany([
    {
        name: "Task 1",
        status: "acabades",
        dateTimeStarted: new Date("2022-01-01T10:00:00Z"),
        dateTimeFinished: new Date("2023-01-01T10:00:00Z"),
        user: "User1"
    },
    {
        name: "Task 2",
        status: "en execució",
        dateTimeStarted: new Date("2022-01-02T11:00:00Z"),
        dateTimeFinished: new Date(null),
        user: "User2"
    },
    {
        name: "Task 3",
        status: "acabades",
        dateTimeStarted: new Date("2021-01-04T13:00:00Z"),
        dateTimeFinished: new Date("2022-01-03T12:00:00Z"),
        user: "User3"
    },
    {
        name: "Task 4",
        status: "pendents",
        dateTimeStarted: new Date("2022-01-04T13:00:00Z"),
        dateTimeFinished: new Date(null),
        user: "User4"
    }
]);