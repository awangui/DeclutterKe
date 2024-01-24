<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('connection.php');
$query="select * from users";
$result=mysqli_query($con,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">

    <title>Users</title>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h2 class="display">Users</h2>
                    </div>
                    <div class="card-body">
                     <table>
                        <tr class="table-header">
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Date Joined</th>
                            <th>Operations</th>
                          
                        </tr>
                        
                            <?php

                            while($row= mysqli_fetch_assoc($result))
                            {
                                $id=$row['UserId'];
                            ?>
                            <tr>
                               
                            <td><?= $id ?></td>
                            <td><?php echo $row['firstName'];?></td>
                            <td><?php echo $row['surname'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['date'];?></td>
                            <td><a href="update.php?editId=<?= $id ?>" class="btn btn-primary">Edit</a><a href="delete.php?deleteid=<?= $id ?>" class="btn btn-danger">Delete</a></td>

                            <!-- <td><a href="#" class="btn btn-danger">Delete</a></td> -->
                            </tr>
                            <?php
                            }
                            ?>
                     </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>