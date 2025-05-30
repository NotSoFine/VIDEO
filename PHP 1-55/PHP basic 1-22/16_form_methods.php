<?php
// Check if form is submitted via GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
    echo "Search query: " . htmlspecialchars($search) . "\n";
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo "Login attempt for user: " . htmlspecialchars($username) . "\n";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Methods Example</title>
</head>
<body>
    <h2>GET Method Example (Search Form)</h2>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" value="Search">
    </form>

    <h2>POST Method Example (Login Form)</h2>
    <form method="POST" action="">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <input type="submit" value="Login">
    </form>

    <h2>When to Use GET vs POST</h2>
    <ul>
        <li>Use GET for:
            <ul>
                <li>Retrieving data</li>
                <li>Search queries</li>
                <li>Filtering results</li>
                <li>When bookmarking should include parameters</li>
            </ul>
        </li>
        <li>Use POST for:
            <ul>
                <li>Submitting sensitive data (passwords)</li>
                <li>Large amounts of data</li>
                <li>File uploads</li>
                <li>Modifying database records</li>
            </ul>
        </li>
    </ul>
</body>
</html>