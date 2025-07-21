<?php

#Getting the books function
function get_all_books($con){
	# SQl query to select all columns from the books table ordered by id in descending order
	$sql = "SELECT * FROM books ORDER BY id DESC";
	#preparing the SQL query
	$stmt = $con->prepare($sql);
	#excute the prepared statement
	$stmt->execute();

    #checking if there are rows returned by the query
	if ($stmt->rowCount() > 0) {
		# code...
		$books = $stmt->fetchAll();
	}else{
		$books = 0;
	}

	return $books;
}

function get_book($con, $id){
    # SQL query to select all columns from the books table where id matches
    $sql = "SELECT * FROM books WHERE id=?";
    # preparing the SQL query
    $stmt = $con->prepare($sql);
    # execute the prepared statement
    $stmt->execute([$id]);

    // fetch the book data
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    // checking if book data is fetched
    if ($book) {
        return $book;
    } else {
        return false; // or any default value to indicate no book found
    }
}

#search book function
function search_book($con, $id){
	# SQl query to select all columns from the books table ordered by id in descending order
	$sql= "SELECT * FROM books WHERE id=?";
	#preparing the SQL query
	$stmt = $con->prepare($sql);
	#excute the prepared statement
	$stmt->execute([$id]);

    #checking if there are rows returned by the query
	if ($stmt->rowCount() > 0) {
		# code...
		$books = $stmt->fetchAll();
	}else{
		$books = 0;
	}

	return $books;
}

#getting book by category fubction 
function get_books_by_category($con, $id){
	# SQL query to select all columns from the books table where id matches
    $sql = "SELECT * FROM books WHERE category_id=?";
    # preparing the SQL query
    $stmt = $con->prepare($sql);
    # execute the prepared statement
    $stmt->execute([$id]);

    #checking if there are rows returned by the query
	if ($stmt->rowCount() > 0) {
		# code...
		$books = $stmt->fetchAll();
	}else{
		$books = 0;
	}

	return $books;

}

#get book by the author
function get_books_by_author($con, $id){

	# SQL query to select all columns from the books table where id matches
    $sql = "SELECT * FROM books WHERE category_id=?";
    # preparing the SQL query
    $stmt = $con->prepare($sql);
    # execute the prepared statement
    $stmt->execute([$id]);

    #checking if there are rows returned by the query
	if ($stmt->rowCount() > 0) {
		# code...
		$books = $stmt->fetchAll();
	}else{
		$books = 0;
	}

	return $books;

}