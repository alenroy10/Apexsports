<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
<?php
    include 'adminheader.php';
    include 'adminmenu.php';
?>
<div class="container mt-5">
    <h2>Manage Users</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>User Type</th>
                    <th>User Status</th>
                    <th>User Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "database.php";
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Query to fetch all users
                $sql = "SELECT * FROM tbl_registration";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // Output data of each user
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["reg_name"] . "</td>";
                        echo "<td>" . ($row["reg_role"] == 0 ? "User" : "Admin") . "</td>";
                        echo "<td class='" . ($row["reg_status"] == 0 ? "status-active" : "status-inactive") . "'>" . ($row["reg_status"] == 0 ? "Active" : "Inactive") . "</td>";
                        echo "<td>" . $row["reg_email"] . "</td>";
                        echo "<td>";
                        if ($row["reg_status"] == 0) {
                            echo "<button class='btn btn-danger' onclick='changeUserStatus(" . $row["reg_id"] . ", 1)'>Deactivate</button>";
                        } else {
                            echo "<button class='btn btn-success' onclick='changeUserStatus(" . $row["reg_id"] . ", 0)'>Activate</button>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function changeUserStatus(userId, status) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload(); // Reload the page after updating the user status
            }
        };
        xhttp.open("POST", "update_user_status.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("userId=" + userId + "&status=" + status);
    }
</script>

</body>
</html>
