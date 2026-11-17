<?php
$user = "example_user";
$password = "Test1234";
$database = "example_database";
$table = "todo_list";

try {
    $db = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=$database",
        $user,
        $password
    );

    echo "<h2>TODO</h2><ol>";

    foreach ($db->query("SELECT content FROM $table") as $row) {
        echo "<li>" . htmlspecialchars($row["content"]) . "</li>";
    }

    echo "</ol>";
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
