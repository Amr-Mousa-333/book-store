<?php 
session_start();

// Database Connection File
include "db_conn.php";

// Book helper function
include_once "php/func-book.php";
$books = get_all_books($conn);

// Author helper function
include_once "php/func-author.php";
$authors = get_all_author($conn);

// Category helper function
include_once "php/func-category.php";
$categories = get_all_categories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Custom styles for book cards */
        .book-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 15px;
            width: 100%;
            max-width: 300px;
        }

        .book-card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 250px;
            object-fit: cover;
        }

        .book-card-body {
            padding: 15px;
            text-align: center;
        }

        .book-card-body h5 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .book-card-body p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .reaction-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .reaction-buttons button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Online Book Store</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Store</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <a class="nav-link" href="admin.php">User</a>
                            <?php } else { ?>
                                <a class="nav-link" href="login.php">Login</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <form action="search.php" method="get" class="my-5" style="max-width: 30rem;">
            <div class="input-group">
                <input type="text" class="form-control" name="key" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">
                <button class="input-group-text btn btn-primary" id="basic-addon2">
                    <img src="img/search.png" width="20">
                </button>
            </div>
        </form>

        <div class="d-flex pt-3">
            <?php if ($books == 0) { ?>
                <div class="alert alert-warning text-center p-5" role="alert">
                    <img src="img/empty.png" width="100">
                    <br>
                    There are no books in the database.
                </div>
            <?php } else { ?>
                <div class="d-flex flex-wrap justify-content-center">
                    <?php foreach ($books as $book) { ?>
                        <div class="book-card">
                            <a href="book-details.php?id=<?= $book['id'] ?>">
                                <img src="uploads/cover/<?= $book['cover'] ?>" class="card-img-top" alt="Book cover">
                            </a>
                            <div class="book-card-body">
                                <h5 class="card-title"><?= $book['title'] ?></h5>
                                <p><i>By: <?= get_author_name($authors, $book['author_id']) ?></i></p>
                                <p><b>Category:</b> <?= get_category_name($categories, $book['category_id']) ?></p>
                                <p><?= substr($book['description'], 0, 100) . "..." ?></p>
                                <a href="uploads/files/<?= $book['file'] ?>" class="btn btn-success">Open</a>
                                <a href="uploads/files/<?= $book['file'] ?>" class="btn btn-primary" download="<?= $book['title'] ?>">Download</a>

                                <!-- Reaction buttons -->
                                <div class="reaction-buttons">
                                    <button class="like-btn">
                                        👍
                                    </button>
                                    <button class="dislike-btn">
                                        👎
                                    </button>
                                    <button class="comment-btn" onclick="location.href='book-details.php?id=<?= $book['id'] ?>'">
                                        💬
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
