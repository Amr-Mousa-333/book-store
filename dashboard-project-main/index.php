<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "online_book_store_db"; // اسم قاعدة البيانات الصحيح
session_start();

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
// إضافة عملية الحذف هنا
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // بعد الحذف، إعادة توجيه المستخدم إلى نفس الصفحة
        header("Location: index.php"); 
        exit; // مهم جدًا لإنهاء تنفيذ السكربت بعد التوجيه
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}



// SQL مع JOIN
$sql = "SELECT books.id, books.title, books.description, books.cover,
               authors.name AS author_name,
               categories.name AS category_name
        FROM books
        LEFT JOIN authors ON books.author_id = authors.id
        LEFT JOIN categories ON books.category_id = categories.id
        ORDER BY books.id DESC";

$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dark dashboard FreeFrontend Code </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Chart.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dark.css">
</head>
<body id="dark">
     <nav class="navbar navbar-expand-sm text-light bg-basic fixed-top border-top">
        <a class="navbar-brand" href="#">Claudy</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                </li>
                <li class="nav-item btn-group dropleft">
                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-comments" aria-hidden="true"></i> <sup class="badge badge-pill badge-danger">20</sup>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item btn-group dropleft nofications">
                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell" aria-hidden="true"></i> <sup class="badge badge-pill badge-danger">99+</sup>
                    </a>
                    <div class="dropdown-menu">
                        <h4 class="dropdown-item mt-0 dropdown-title">Nouvelles notifications</h4>
                        <a class="dropdown-item" href="#">
                            <img src="images/default-avatar.png" alt="">
                            <span>Claudy vient de se désabonner</span><br>
                            <span class="text-mutee">A l'instant</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/avataaars.png" alt="">
                            <span>Jeanne a mentionné votre nom</span>
                            <br>
                            <span class="text-mutee">Il y a 30min.</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/anime3.png" alt="">
                            <span>John Doe a signalé un problème</span> <br>
                            <span class="text-mutee">Il y a 2h.</span>
                        </a>
                        <div class="dropdown-divider "></div>
                        <center><a class="dropdown-item" href="#"><button type="button" class="btn btn-info">Toutes les nofifications</button></a></center>

                    </div>
                </li>
                <li class="nav-item btn-group dropleft">
                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i><sup class="badge badge-pill badge-danger">91</sup>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item btn-group dropleft">
                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-calendar-alt    "></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item btn-group dropleft">
                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/anime6.png" alt="" class="avatar rounded-circle mx-auto d-block">
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item btn-group dropleft">
                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu">
                        <form class="dropdown-item">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="darkMode" id="darkMode" value="checkedValue"> <span class="darkMode">Mode Sombre</span>
                            </label>
                            </div>
                        </form>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
    <div class="wrapper ">
        <div class="sideMenu ">
             <div class="sidebar ">
                <ul class="nav justify-content-center flex-column">
                    <li class="nav-item">
                        <a class="nav-link active dropBtn" href="#">
                            <span class="angle"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <i class="fa fa-qrcode" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="">Like ours eeh...</a>
                            <a href="">Like oqojo ..</a>
                            <a href="">Like jsgss ..</a>
                        </div>
                    </li>
                </ul>
            </div
        </div>
        <div class="content ">
            <div class="task-bar top-navbar">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Acceuil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Action</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Another link</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link disabled">Disabled</a>
                    </li>

                    <form class="ml-auto nav-item form-inline my-2 my-lg-0 pr-4">
                        <div class="input-group bg-mi-transparent border-rad-normal">

                            <div class="input-group-append">
                                <input type="text" class="border-left-normal bg-mi-transparent border-none">
                            </div>
                            <button class="input-group-text bg-transparent border-none"><i class="fas fa-search text-light  "></i></button>
                        </div>
                    </form>
<li class="nav-item">
    <a class="nav-link" href="http://localhost/online-book-store-main/logout.php">تسجيل الخروج</a>
</li>

                </ul>
            </div>
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
  Create New
</button> -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content text-dark">
        <div class="modal-header">
          <h5 class="modal-title">Add Item</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <form method="POST">
          <div class="modal-body">
            <input type="text" name="name" class="form-control mb-2" placeholder="Item Name" required>
            <textarea name="description" class="form-control" placeholder="Description"></textarea>
          </div>
          
          <div class="modal-footer">
            <button type="submit" name="add" class="btn btn-success">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<table class="table table-dark table-striped">
    
  <thead>
    <tr>
      <th>#</th>
      <th>العنوان</th>
      <th>المؤلف</th>
      <th>الوصف</th>
      <th>الفئة</th>
      <th>الغلاف</th>
      <th>حذف</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['author_name']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td><?= htmlspecialchars($row['category_name']) ?></td>
          
         <td>
  <?php if (!empty($row['cover'])): ?>
    <img src="../uploads/cover/<?= htmlspecialchars($row['cover']) ?>" alt="cover" width="60">
  <?php else: ?>
    <span class="text-muted">No cover</span>
  <?php endif; ?>
</td>
<td>
    <!-- زر الحذف مع رابط إعادة تحميل الصفحة -->
    <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
</td>


        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6">لا توجد كتب</td></tr>
    <?php endif; ?>
  </tbody>
</table>

</div>
        </div>
      </form>
    </div>
  </div>
</div>
 </div>

    </div>
    <script src="js/jquery-3.4.1.min.js "></script>
    <script src="js/popper.min.js "></script>
    <script src="js/bootstrap.min.js "></script>
    <script src="js/all.js "></script>
    <script src="js/Chart.js"></script>
</body>
</html>
