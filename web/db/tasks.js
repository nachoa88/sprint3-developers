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
                    bsonType: 'date'
                },
                dateTimeFinished: {
                    bsonType: 'date'
                },
                user: {
                    bsonType: 'string'
                }
            }
        }
    },
    autoIndexId: true
});