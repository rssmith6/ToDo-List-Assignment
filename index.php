<?php 
require('model/database.php');
require('model/category_db.php');
require('model/todolist_db.php');

$taskID = filter_input(INPUT_POST, 'taskID', FILTER_VALIDATE_INT);
$title = filter_input(INPUT_POST, "title", FILTER_UNSAFE_RAW);
$description = filter_input(INPUT_POST, "description", FILTER_UNSAFE_RAW);
$categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_UNSAFE_RAW);

$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);
if(!$categoryID) {
    $categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);
}

$action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW);
if(!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);
    if(!$action) {
        $action = 'list_tasks';
    }
}

switch($action) {
    case "list_categories":
        $categories = get_categories();
        include('view/category_list.php');
        break;
    case "add_category":
        insert_category($categoryName);
        header("Location: .?action=list_categories");
        break;
    case "add_task":
        if($title && $categoryID && $description) {
            insert_task($title, $categoryID, $description);
            header("Location: .?categoryID=$categoryID");
        } else {
            $error_message = "Invalid task data. Check all fields and try again.";
            include('view/error.php');
            exit();
        }
        break;
    case "delete_category":
        if($categoryID) {
            try {
                delete_category($categoryID);
            } catch (PDOExecption $e) {
                $error_message = "You cannot delete a category if tasks exist for it.";
                include('view/error.php');
                exit();
            }
            header("Location: .?action=list_categories");
        }
        break;
    case "delete_task":
        if($taskID) {
            delete_task($taskID);
            header("Location: .?categoryID=$categoryID");
        } else {
            $error_message = "Missing or incorrect task ID.";
            include('view/error.php');
        }
        break;
    default:
        $categoryName = get_categories_name($categoryID);
        $categories = get_categories();
        $tasks = get_item_by_category($categoryID);
        include('view/tasklist.php');
        break;
}
?>
