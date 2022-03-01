<?php

function insert_task($title, $categoryID, $description) {
    global $db;
    $count = 0;
    $query = 'INSERT INTO todoitems
                (Title, Description, CategoryID)
                    VALUES
                        (:title, :description, :categoryID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':categoryID', $categoryID);
    if($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}

function delete_task($taskID) {
    global $db;
    $count = 0;
    $query = 'DELETE FROM todoitems
                WHERE ItemNum =:id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $taskID);
    if($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}

function get_item_by_category($categoryID) {
    global $db;
    if($categoryID) {
        $query = 'SELECT T.Title, T.Description, T.ItemNum, C.categoryName FROM todoitems T
                    Left JOIN categories C ON T.categoryID = C.categoryID
                        WHERE T.categoryID = :categoryID Order BY ItemNum';
    } else {
        $query = 'SELECT T.Title, T.Description, T.ItemNum, C.categoryName FROM todoitems T
                    Left JOIN categories C ON T.categoryID = C.categoryID
                        Order BY ItemNum';

    }
    $statement = $db->prepare($query);
    if($categoryID) {
        $statement->bindValue(':categoryID', $categoryID);
    }
    $statement->execute();
    $tasks = $statement->fetchAll();
    $statement->closeCursor();
    return $tasks;
}
?>