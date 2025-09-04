<?php 
session_start();

// Database connection (make sure it's using PDO)
include "db_conn.php";

// Check if the form is submitted to add a comment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user_name = htmlspecialchars(trim($_POST['user_name']));
    $comment_text = htmlspecialchars(trim($_POST['comment_text']));
    $book_id = $_POST['book_id'];

    // Check if the fields are not empty
    if (empty($user_name) || empty($comment_text)) {
        echo "<script>alert('Please fill all fields'); window.history.back();</script>";
        exit;
    }

    // Insert the comment into the database using PDO
    $sql = "INSERT INTO comments (book_id, user_name, comment_text) VALUES (:book_id, :user_name, :comment_text)";
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Comment added successfully'); window.location.href = 'book-details.php?id=$book_id';</script>";
    } else {
        echo "<script>alert('Something went wrong, please try again later'); window.history.back();</script>";
    }
}

// Get book details based on the book id
$book_id = $_GET['id'];  // assuming you pass the book id via GET method
$sql_book = "SELECT * FROM books WHERE id = :book_id";
$stmt = $conn->prepare($sql_book);
$stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
$stmt->execute();
$book = $stmt->fetch(PDO::FETCH_ASSOC);

// Get comments for the book
$sql_comments = "SELECT * FROM comments WHERE book_id = :book_id ORDER BY created_at DESC";
$stmt = $conn->prepare($sql_comments);
$stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .comment-box {
            background-color: #f8f9fa;
            padding: 15px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .comment-box .comment-author {
            font-weight: bold;
            color: #007bff;
        }

        .comment-box .comment-text {
            margin-top: 5px;
            color: #333;
        }

        .comment-box .comment-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .form-container {
            background-color: #f1f3f5;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-container input,
        .form-container textarea {
            margin-bottom: 10px;
        }

        .form-container button {
            width: 100%;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5"><?= htmlspecialchars($book['title']) ?></h1>
        <p><strong>By:</strong> <?= htmlspecialchars($book['author_id']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($book['description']) ?></p>

        <!-- Display the comments -->
        <h2>Comments</h2>
        <?php foreach ($comments as $comment) { ?>
            <div class="comment-box">
                <div class="comment-author"><?= htmlspecialchars($comment['user_name']) ?></div>
                <div class="comment-text"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></div>
                <div class="comment-time"><?= $comment['created_at'] ?></div>
            </div>
        <?php } ?>

        <!-- Add a new comment -->
        <div class="form-container">
            <h3>Add a Comment</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="user_name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" name="user_name" required>
                </div>
                <div class="mb-3">
                    <label for="comment_text" class="form-label">Your Comment</label>
                    <textarea class="form-control" name="comment_text" required></textarea>
                </div>
                <input type="hidden" name="book_id" value="<?= $book_id ?>">
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</body>
</html>
