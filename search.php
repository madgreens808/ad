<?php
// search.php - intentionally reflects user input (XSS)
$q = $_GET['q'] ?? '';
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>VulnApp Search</title></head>
<body>
<h2>Search</h2>
<form method="get" action="search.php">
  Query: <input type="text" name="q" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>">
  <input type="submit" value="Search">
</form>
<p>Showing results for: <?php echo $q; ?></p>
</body>
</html>
