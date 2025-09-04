<?php
session_start();

// Database connection
include "db_conn.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $user_name = htmlspecialchars(trim($_POST['user_name']));
    $comment_text = htmlspecialchars(trim($_POST['comment_text']));
    $book_id = $_POST['book_id'];

    // Validate input
    if (empty($user_name) || empty($comment_text)) {
        echo "<script>alert('Please fill all fields'); window.history.back();</script>";
        exit;
    }

    // Insert the comment into the database
    $sql = "INSERT INTO comments (book_id, user_name, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $book_id, $user_name, $comment_text);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the book details page
        echo "<script>alert('Comment added successfully'); window.location.href = 'book-details.php?id=$book_id';</script>";
    } else {
        echo "<script>alert('Something went wrong, please try again later'); window.history.back();</script>";
    }
}
?>
