<?php 

# Get all Author function
function get_all_author($con){
   #SQL query to slect all columns from the authors table
   $sql  = "SELECT * FROM authors";
   #preparing the SQL query
   $stmt = $con->prepare($sql);
   #executing the prepared statement 
   $stmt->execute();

   #checking if there are rows returned by the query
   if ($stmt->rowCount() > 0) {
   	  $authors = $stmt->fetchAll();
   }else {
      $authors = 0;
   }

   return $authors;
}


# Get  Author by ID function
function get_author($con, $id){
   #SQL query to select all columns from teh authors table where the id matches the provided parameters  
   $sql  = "SELECT * FROM authors WHERE id=?";
   #preparing the SQL query
   $stmt = $con->prepare($sql);
   #executing the prepared statement 
   $stmt->execute([$id]);

   #checking if there are rows returned by the query
   if ($stmt->rowCount() > 0) {
   	  $author = $stmt->fetch();
   }else {
      $author = 0;
   }
   #Return the result, which could be an array representing the author or 0 if no author was found
   return $author;
}