package com.college;

import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.*;
import java.io.*;
import java.nio.file.*;

@WebServlet("/file")
public class FileServlet extends HttpServlet {

    private static final String UPLOAD_DIR =
        "C:/college_portal/uploads/";

    protected void doGet(HttpServletRequest request,
                          HttpServletResponse response)
            throws ServletException, IOException {

        HttpSession session = request.getSession(false);

        if (session == null || !Boolean.TRUE.equals(session.getAttribute("loggedIn"))) {
            response.sendError(HttpServletResponse.SC_UNAUTHORIZED);
            return;
        }

        String name = request.getParameter("name");

        // Reject path traversal attempts.
        if (name == null || name.contains("..") ||
            name.contains("/") || name.contains("\") ||
            name.isBlank()) {
            response.sendError(HttpServletResponse.SC_BAD_REQUEST);
            return;
        }

        Path file = Paths.get(UPLOAD_DIR).resolve(name).normalize();

        if (!Files.exists(file) || !Files.isRegularFile(file)) {
            response.sendError(HttpServletResponse.SC_NOT_FOUND);
            return;
        }

        String contentType = getServletContext().getMimeType(file.toString());
        if (contentType == null) contentType = "application/octet-stream";

        response.setContentType(contentType);
        response.setContentLengthLong(Files.size(file));

        try (InputStream in = Files.newInputStream(file);
             OutputStream out = response.getOutputStream()) {

            byte[] buffer = new byte[8192];
            int bytesRead;

            while ((bytesRead = in.read(buffer)) != -1) {
                out.write(buffer, 0, bytesRead);
            }
        }
    }
}
