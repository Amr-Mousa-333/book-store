<?php  

# Get all Categories function
function get_all_categories($con){
   $sql  = "SELECT * FROM categories";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $categories = $stmt->fetchAll();
   }else {
      $categories = 0;
   }

   return $categories;
}

function get_category_name($categories, $category_id) {
    foreach ($categories as $category) {
        if ($category['id'] == $category_id) {
            return $category['name']; // إرجاع اسم الفئة بناءً على الـ category_id
        }
    }
    return "Unknown Category"; // في حال لم يتم العثور على الفئة
}

# Get category by ID
function get_category($con, $id){
   $sql  = "SELECT * FROM categories WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $category = $stmt->fetch();
   }else {
      $category = 0;
   }

   return $category;
}