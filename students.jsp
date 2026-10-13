<%@ page import="java.util.List" %>
<%@ page import="com.college.Student" %>

<!DOCTYPE html>
<html>
<head><title>Students</title></head>
<body>
<h1>Student Profiles</h1>

<table border="1" cellpadding="8">
<tr>
    <th>Name</th>
    <th>Roll No</th>
    <th>Email</th>
    <th>Course</th>
    <th>Profile</th>
</tr>

<%
List<Student> students =
    (List<Student>) request.getAttribute("students");

if (students != null && !students.isEmpty()) {
    for (Student s : students) {
%>
<tr>
    <td><%= s.getName() %></td>
    <td><%= s.getRollNo() %></td>
    <td><%= s.getEmail() %></td>
    <td><%= s.getCourse() %></td>
    <td>
        <a href="profile.jsp?id=<%= s.getId() %>">View</a>
    </td>
</tr>
<%
    }
} else {
%>
<tr><td colspan="5">No student records found.</td></tr>
<%
}
%>
</table>
</body>
</html>
