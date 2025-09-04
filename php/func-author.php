<?php 

# Get all Author function
function get_all_author($con){
   $sql  = "SELECT * FROM authors";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $authors = $stmt->fetchAll();
   }else {
      $authors = 0;
   }

   return $authors;
}
function get_author_name($authors, $author_id) {
    foreach ($authors as $author) {
        if ($author['id'] == $author_id) {
            return $author['name']; // إرجاع اسم المؤلف بناءً على الـ author_id
        }
    }
    return "Unknown Author"; // في حال لم يتم العثور على المؤلف
}


# Get  Author by ID function
function get_author($con, $id){
   $sql  = "SELECT * FROM authors WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $author = $stmt->fetch();
   }else {
      $author = 0;
   }

   return $author;
}