# Student Management Web Technology Assignment

Educational project demonstrating an HTML/CSS/JavaScript registration form, PHP/MySQL CRUD, file uploads, and a Java Servlet/JDBC/JSP portal.

## Folders
- `frontend/` — registration form, CSS and validation
- `php/` — database connection, CRUD pages and file upload
- `database/schema.sql` — MySQL schema
- `servlet/` — Maven web app, servlets, JSP and `WEB-INF/web.xml`
- `screenshots/` — illustrative output previews

## PHP setup
1. Install XAMPP or another PHP/MySQL stack.
2. Start Apache and MySQL; import `database/schema.sql`.
3. Edit `php/db.php` with your local MySQL credentials.
4. Place the folder under the web server document root.
5. Open `frontend/index.html`; open `php/index.php` for records.

## Servlet setup
1. Install JDK 17+, Maven and Tomcat 10.1 or another Jakarta Servlet 6 server.
2. Update credentials in `DBConnection.java`.
3. Update `FileServlet.java` `UPLOAD_DIR` to the actual upload directory.
4. From `servlet/`, run `mvn package` and deploy the WAR to Tomcat.
5. Open `login.jsp`. Demo credentials: `admin` / `admin123`.

## Notes
This is an educational starter project. Test it in your own environment before submission. Replace demo login with database-backed authentication before production. Do not commit real credentials or private student documents. Replace illustrative screenshot previews with screenshots from your running application.
