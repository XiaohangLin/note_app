<?php
require_once('database.php');

// Get all notes from the database
$query = 'SELECT * FROM sk_notes ORDER BY created_at DESC';
$statement = $db->prepare($query);
$statement->execute();
$notes = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Notes</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
    <header><h1>My Notes</h1></header>
    <main>
        <h2>Note List</h2>
        
        <!-- Filter by Tags -->
        <form action="notes_list.php" method="get">
            <label>Filter by Tags:</label>
            <select name="tag">
                <option value="">All Tags</option>
                <?php
                $query = 'SELECT DISTINCT tags FROM sk_notes';
                $statement = $db->prepare($query);
                $statement->execute();
                $tags = $statement->fetchAll();
                $statement->closeCursor();
                foreach ($tags as $tag) {
                    echo '<option value="' . $tag['tags'] . '">' . $tag['tags'] . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Filter">
        </form>
        
        <table>
            <tr>
                <th>Title</th>
                <th>Tags</th>
                <th>Created At</th>
            </tr>
            <?php foreach ($notes as $note) : ?>
                <tr>
                    <td><?php echo $note['title']; ?></td>
                    <td><?php echo $note['tags']; ?></td>
                    <td><?php echo $note['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>
