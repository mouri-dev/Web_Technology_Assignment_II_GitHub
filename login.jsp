<!DOCTYPE html>
<html>
<head><title>Portal Login</title></head>
<body>
<h1>Student Portal Login</h1>

<form action="login" method="post">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

<% if (request.getAttribute("error") != null) { %>
    <p style="color:red;">
        <%= request.getAttribute("error") %>
    </p>
<% } %>
</body>
</html>
