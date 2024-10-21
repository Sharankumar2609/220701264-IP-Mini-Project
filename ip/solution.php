<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Solution Page</title>
</head>
<body>
    <header>
        <div>
            <h1 id="tit">HEALTH IMPROVER</h1>
            <a href="index.php" id="home">Home</a>
            <a href="select.php" id="sele">Select </a>
            <!-- <a href="Solution.php" id="solution">Solution</a> -->
        </div>
    </header>
    
    <div class="sol">
        <form method="post">
            <input type="text" name="search" placeholder="search for a disease..." id="inp" required>
            <button id="sear" type="submit">Search</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";  // Database server
        $username = "root";          // Your MySQL username
        $password = "";              // Your MySQL password
        $dbname = "rds";             // The database you want to connect to

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the search term and prevent SQL injection
        $disease = $conn->real_escape_string($_POST['search']);
        $sql = "SELECT * FROM solu WHERE disease_name='$disease'";  // Change disease_name if needed
        $result = $conn->query($sql);

        // Check if there are results and display them
        if ($result && $result->num_rows > 0) {
            echo "<h2>Search Results for '$disease':</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li><strong>Disease:</strong> " . htmlspecialchars($row['disease_name']) . "<br>";
                echo "<strong>Doctor:</strong> " . htmlspecialchars($row['doctor']) . "<br>";
                echo "<strong>Diet:</strong> " . htmlspecialchars($row['diet']) . "<br>";
                echo "<strong>Video:</strong> <a href='" . htmlspecialchars($row['video']) . "' target='_blank'>Watch here</a>";
                echo "</li><br>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found for '$disease'.</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
