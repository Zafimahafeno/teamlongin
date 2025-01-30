<?php
// update_vote.php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['id']) && isset($_POST['vote'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $vote = $conn->real_escape_string($_POST['vote']);
    
    $sql = "UPDATE votant SET intentionVote = '$vote' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>