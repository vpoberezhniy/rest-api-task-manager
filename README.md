*********   API Doc   ***********
*****************************
Auth:
- /api/register - registr new user (POST)
  request:
  {
  "name": "Test User 2",
  "email": "test2@example.com",
  "password": "password"
  }


- /api/login - login user (POST)
  request:
  {
  "email": "test@example.com",
  "password": "password"
  }


- /api/logout - logout user (POST)


Tasks:
- /api/tasks - get all tasks for current user (GET; Authorization: Bearer token)

- /api/tasks - create new task (POST)
  request:
  {
  "title": "New Task 4",
  "description": "Description sxvcxvdafdsfsdfcxv vc xcv xcvxcv xzcv zxcvzcx vof the new task",
  "status": "pending",
  "team_id": null
  }

- /api/tasks/{id}/edit - edit task for current user (GET)

- /api/tasks/{id} - update task for current user (PUT)
  request:
  {
  "title": "Updated Task Title",
  "description": "Updated description of the task",
  "status": "in progress",
  "team_id": null
  }

- /api/tasks/{id} - delete task for current user (Delete)

Comments:
- /api/tasks/{tasks_id}/comments - add comment for task from current user (POST)
  request:
  {
  "comment": "88 sdsdfThis sdfsdfsadfasdfasdfasdfis a comment for the task hjgvkdgfldsffsdf."
  }

- /api/tasks/{tasks_id}/comments - get all comment for current task (GET)
- /api/comments/{comment_id} - delete current comment (DELETE)


Teams:
- /api/teams - create new team (POST)
  request:
  {
  "name": "The best team"
  }

- /api/teams - get team list for current user (GET)

- /api/teams/{team_id}/users - add user for current team (POST)
  request:
  {
  "user_id": 1
  }

- /api/teams/{team_id}/users/{user_id} - delete user from team (DELETE)
 
 
 
