<?php
require_once('../database.php');

// Check if noteID is set in the URL
if (isset($_GET['noteID'])) {
    $noteID = $_GET['noteID'];
    
    // Fetch note details from the database
    $query = 'SELECT * FROM sk_notes WHERE noteID = :note_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':note_id', $noteID, PDO::PARAM_INT);
    $statement->execute();
    $note = $statement->fetch();
    $statement->closeCursor();
    
    // Set default values for the form fields
    $default_title = $note['title'];
    $default_content = $note['content'];
    $default_tags = $note['tags'];
}
?>

<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Edit Note</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
</head>

<!-- the body section -->
<body>
    <header><h1>Edit Note</h1></header>
    <main>
        <form action="../api/edit_note.php" method="post" id="edit_note_form">
            <input type="hidden" name="id" value="<?php echo $note['noteID']; ?>">
            
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo isset($default_title) ? $default_title : ''; ?>" required><br>
            
            <label>Content:</label>
            <textarea name="content" rows="4" cols="50" required><?php echo isset($default_content) ? $default_content : ''; ?></textarea><br>
            
            <label>Tags:</label>
            <input type="text" name="tags" value="<?php echo isset($default_tags) ? $default_tags : ''; ?>"><br>
            
            <label>&nbsp;</label>
            <input type="submit" value="Save Changes"><br>
        </form>
    </main>

    <footer>
    <p>&copy; <?php echo date("Y"); ?> Xiaohang Lin. All rights reserved.</p>
    </footer>
</body>
</html>
