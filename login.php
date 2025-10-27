<?php
// login.php - intentionally vulnerable, minimal requirements
session_start();
$db = new SQLite3(__DIR__.'/vuln.db');
$db->exec('CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, username TEXT, password TEXT)');
$db->exec("INSERT OR IGNORE INTO users(id,username,password) VALUES(1,'admin','adminpass')");

// Process login - vulnerable string concatenation simulating SQLi
$login_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    // Vulnerable: naive string check instead of prepared statements
    $query = "SELECT * FROM users WHERE username = '$u' AND password = '$p'";
    $res = $db->query($query);
    if ($res->fetchArray()) {
        $_SESSION['user'] = htmlspecialchars($u, ENT_QUOTES);
        $login_msg = 'Login successful for user: ' . htmlspecialchars($u, ENT_QUOTES);
    } else {
        $login_msg = 'Login failed for user: ' . htmlspecialchars($u, ENT_QUOTES);
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>VulnApp Login</title></head>
<body>
<h2>Login</h2>
<form method="post" action="login.php">
  Username: <input type="text" name="username"><br>
  Password: <input type="password" name="password"><br>
  <input type="submit" value="Login">
</form>
<p><?php echo $login_msg; ?></p>
<hr>
<a href="search.php">Search page (reflects input)</a>
</body>
</html>
