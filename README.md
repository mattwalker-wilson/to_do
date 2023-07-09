# Full-stack Recruitment Test

1. Make sure you have a MySQL server running
2. Create a MySQL database called "to_do"
3. Clone this repo into you local development environment
4. Copy .env.example to .env and change the DB_USERNAME and DB_PASSWORD values for your MySQL installation
5. Open a teminal window / GIT BASH window and CD into the folder "to_do". This is the Root directory for the PHP API
6. Run the migrations with "php artisan migrate"
7. Visit "http://127.0.0.1:8000/api" If the API has started, you should see a welcome message,
7. Start up the PHP Laravel API with "php artisan serve"
5. Open another GIT BASH Window
6. CD into the sub directory "to_do/todo-app"    This is root directory for ReactJS scripts
7. Start the ReactJS app with "npm start"
8. "http://localhost:3000/register"  to register your email and a password.  The email does not need to be a real accessible email. No emails are ever sent to the address
9. Having registered, you can login at "http://localhost:3000"
10. Use the to nav menu to "Create New List" or visit "http://localhost:3000/create"
11. Click the Blue + icon at the end of the list name to add an item to this list.


### Task 
Create a basic Todo application which satisfies the user stories listed below.  

1. As a user, I can create a `TodoList`  - **Completed Frontend and Backend**
2. As a user, I can view a list of my `TodoList`s - **Completed Frontend and Backend**
3. As a user, I can rename my `TodoList`s - *Completed Backend*
4. As a user, I can delete a `TodoList` - **Completed Frontend and Backend**
5. As a user, I can add a `Todo` item to a `TodoList` - **Completed Frontend and Backend**
6. As a user, I can see all the `Todo` items on my `TodoList` - **Completed Frontend and Backend**
7. As a user, I can delete `Todo` items from my `TodoList`  - **Completed Frontend and Backend**
8. As a user, I can mark `Todo` items as completed - **Completed Frontend and Backend**

## Follow-up Questions
1. How long did you spend on the coding test?
2. Which parts were the most challenging?
3. What would you add to your solution if you had time? What further improvements or features would you add?
4. How would you track down a performance issue in production? Have you ever had to do this?
