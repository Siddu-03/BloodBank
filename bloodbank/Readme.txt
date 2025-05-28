                                                       OVERVIEW OF THE FILE STURCTURE:

CSS : contains all the css files for styling
JS : contains the app.js file
DATABASE : conatins the source code of the databse one with test data one without test data
PHP : conatins the html source code files integrated to backend using PHP 





                                            HOW TO USE THIS PROJECT FROM GITHUB ON YOUR LOCAL SYSTEM:

1. Clone the repository:
   - Open terminal or Git Bash.
   - Run: git clone https://github.com/yourusername/blood-vault.git

2. Set up the local server environment:
   - Install XAMPP (recommended).
   - Open XAMPP Control Panel and start Apache and MySQL.

3. Move the project:
   - Copy the cloned folder into XAMPP's htdocs directory.[all files into one folder => bloodbank]
   - Example path: C:/xampp/htdocs/bloodbank

4. Import the database:
   - Open phpMyAdmin (http://localhost/phpmyadmin).
   - Create a new database named: blood_bank 
   - Import the provided SQL file (usually in the `database/` folder).

5. Configure database connection:
   - Open `db_connect.php`.
   - Ensure the database name, username, and password match your local setup.
     Example:
     $conn = new mysqli("localhost", "root", "", "bloodbank");

6. Run the project:
   - Visit: http://localhost/bloodbank
   - Use the login and registration system to start using the platform.

7. Default credentials:
   - You may use any registered user email/password from MobileUser table.
   - Or register as a donor, hospital, or blood bank to test all roles.

8. Notes:
   - Ensure all file names and paths match.
   - If styles or JS are not loading, check folder structure or paths in HTML.
   - This project is optimized for the first phase submission; extend as needed.

Happy hacking! 🩸

