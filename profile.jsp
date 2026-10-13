<%@ page import="java.sql.*" %>
<%@ page import="com.college.DBConnection" %>

<%
    HttpSession currentSession = request.getSession(false);
    if (currentSession == null ||
        !Boolean.TRUE.equals(currentSession.getAttribute("loggedIn"))) {
        response.sendRedirect("login.jsp");
        return;
    }

    int id = Integer.parseInt(request.getParameter("id"));

    String name = "";
    String rollNo = "";
    String email = "";
    String course = "";

    try (Connection con = DBConnection.getConnection();
         PreparedStatement ps = con.prepareStatement(
             "SELECT name, roll_no, email, course FROM students WHERE id=?")) {

        ps.setInt(1, id);

        try (ResultSet rs = ps.executeQuery()) {
            if (rs.next()) {
                name = rs.getString("name");
                rollNo = rs.getString("roll_no");
                email = rs.getString("email");
                course = rs.getString("course");
            }
        }
    }
%>

<!DOCTYPE html>
<html>
<head><title>Student Profile</title></head>
<body>
<h1>Student Profile</h1>

<p><b>Name:</b> <%= name %></p>
<p><b>Roll Number:</b> <%= rollNo %></p>
<p><b>Email:</b> <%= email %></p>
<p><b>Course:</b> <%= course %></p>

<!-- The image/file endpoint streams the stored file. -->
<img src="file?name=profile.jpg" width="180"
     alt="Student profile image">

</body>
</html>
