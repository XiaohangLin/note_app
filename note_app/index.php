<?php
require_once('database.php');
?>

<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <script src="main.js"></script>
</head>

<!-- the body section -->
<body>
    <header><h1><?php echo $page_title; ?></h1></header>
<main>
    <?php
    $query = 'SELECT * FROM sk_notes ORDER BY created_at DESC';
    $statement = $db->prepare($query);
    $statement->execute();
    $notes = $statement->fetchAll();
    $statement->closeCursor();
    ?>

    <h2>Note List</h2>
    
    <!-- Filter by Tags -->
    <form id="filterForm">
    <label>Filter by Tags:</label>
    <select name="tag" id="tagFilter">
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
    <input type="button" value="Filter" onclick="filterNotes()">
</form>

    <table id="noteTable">
        <tr>
            <th>Title</th>
            <th>Tags</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <tbody id="noteTableBody">
            <?php foreach ($notes as $note) : ?>
                <tr>
                    <td><?php echo $note['title']; ?></td>
                    <td><?php echo $note['tags']; ?></td>
                    <td><?php echo $note['created_at']; ?></td>
                    <td>
                        <button class="show-content" data-note-content="<?php echo $note['content']; ?>">Show Content</button>
                        <button class="edit-note" data-note-id="<?php echo $note['noteID']; ?>">Edit</button>
                        <button class="delete-note" data-note-id="<?php echo $note['noteID']; ?>">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="rest.php?format=json&action=notes">View Notes (JSON)</a></p>
    <p><a href="rest.php?format=xml&action=notes">View Notes (XML)</a></p>
    <?php include('views/create_note_form.php'); ?>
</main>



<footer>
    <p>&copy; <?php echo date("Y"); ?> Xiaohang Lin. All rights reserved.</p>
</footer>
</body>
</html>
