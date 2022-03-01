<?php 

function get_categories() {
    global $db;
    $query = 'SELECT * FROM categories ORDER BY categoryID';
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
    $statement->closeCursor();
    return $categories;
}

function get_categories_name($categoryID){
    if(!$categoryID) {
        return "All Courses";
    }
    global $db;
    $query = 'SELECT * FROM categories WHERE categoryID = :categoryID';
    $statement= $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->execute();
    $category = $statement->fetch();
    $statement->closeCursor();
    $categoryName = $category['categoryName'];
    return $categoryName;
}

function delete_category($categoryID) {
    global $db;
    $query = 'DELETE FROM categories WHERE categoryID = :categoryID';
    $statement= $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->execute();
    $statement->closeCursor();
}

function insert_category($categoryName) {
    global $db;
    $count = 0;
    $query = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryName', $categoryName);
    if($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}

?>