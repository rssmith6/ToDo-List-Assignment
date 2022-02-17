


<?php 



#I spent a long time trying to get the delete to work and I couldn't figure it out.

#Robert Smith
#2/16/22


require('database.php');
$title=filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$description=filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List Assignment</title>
    <link rel="Stylesheet" href="css/main.css">
</head>
<body>
    <center>
    <header>
        <h1>To Do List</h1>
    </header>
    <form action="" method="POST">
        <table width="50%" border="1" cellpadding="5" cellspacing="10">
            <tr>
                <td>
                    
                        <input type="text" name="title" placeholder="Enter new task"/></br>
                        <input type="text" name="description" placeholder="Description of the task"/></br>
                        <button type="submit" name="insert">Submit Task</button>
                </td>
            </tr>
        </table>
        <form action="" method="POST">
        <table width="50%" border="1" cellpadding="5" cellspacing="10">
            <thead>
                <tr>  
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <?php 
                $query = "SELECT * FROM todoitems";
                $statement= $db->prepare($query);
                $statement->execute();

                $result = $statement->fetchAll();
                if($result) {
                    foreach($result as $row) {
                        ?>
                        <tr>
                            <td><?= $row['Title']; ?></td>
                            <td><?= $row['Description']; ?></td>
                            <?php echo '<td><button type="submit" name="Delete" value='.$row['ItemNum'].'" />Delete</button></td>"'; ?>
                            
                        </tr>
                        <?php }

                } else {
                    ?>
                    <tr>
                        <td colspan = "3">Your list is empty!</td>
                    </tr>
                    <?php 

                }
            ?>
            </table>
            </form>
    </form>
    
    </center>   

</body>
</html>

<?php 
if($title) {
    $query = 'INSERT INTO todoitems (Title, Description)
                VALUES (:title, :description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}
?>

<?php
if(isset($_POST['Delete'])) {
    $ItemNum = filter_input(INPUT_POST, 'ItemNum', FILTER_VALIDATE_INT);

    $query = 'DELETE FROM todoitems
                WHERE ItemNum =:ItemNum';
    $statement=$db->prepare($query);
    $statement->bindValue(':ItemNum', $ItemNum);
    $statement->execute();
    $statement->closeCursor();
}

