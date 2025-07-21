<?php

# Get all Category function
function get_all_categories($con){
   #SQL query to select all columns from the categories table
   $sql  = "SELECT * FROM categories";
   #preparing the SQL query
   $stmt = $con->prepare($sql);
   #executing the prepared statement 
   $stmt->execute();

   #checking if there are rows returned by the query
   if ($stmt->rowCount() > 0) {
   	  $categories = $stmt->fetchAll();
   } else {
      $categories = 0;
   }

   return $categories;

}
# Get category by ID
function get_category($con, $id){
   #SQL query to select all columns from the 'categories' table where the 'id' matches the provided parameter
   $sql  = "SELECT * FROM categories WHERE id=?";
   #preparing the SQL query
   $stmt = $con->prepare($sql);
   #executing the prepared statement 
   $stmt->execute([$id]);

   #checking if there are rows returned by the query
   if ($stmt->rowCount() > 0) {
   	  $category = $stmt->fetch();
   }else {
      $category = 0;
   }

   return $category;
}
