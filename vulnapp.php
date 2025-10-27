<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "vuln_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['user'])) {
    $user = $_GET['user'];

    // Vulnerable to SQLi
    $query = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Vulnerable to XSS since no escaping
            echo "User: " . $row['username'] . "<br>";
            echo "Comment: " . $row['comment'] . "<br>";
        }
    } else {
        echo "No user found";
    }
} else {
    echo "Please provide a user parameter in the URL, e.g. ?user=alice";
}

$conn->close();
?>
