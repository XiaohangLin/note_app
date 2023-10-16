<?php
require_once('database.php');

$format_type = isset($_GET['format']) ? $_GET['format'] : 'json';
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'notes') {
    $query = 'SELECT * FROM sk_notes';
    $statement = $db->prepare($query);
    $statement->execute();
    $notes = $statement->fetchAll();
    $statement->closeCursor();
    
    if ($format_type === 'xml') {
        // Handle XML response
        header('Content-Type: application/xml');
        echo '<notes>';
        foreach ($notes as $note) {
            echo '<note>';
            echo '<title>' . $note['title'] . '</title>';
            echo '<content>' . $note['content'] . '</content>';
            echo '<tags>' . $note['tags'] . '</tags>';
            echo '</note>';
        }
        echo '</notes>';
    } else {
        // Handle JSON response
        header('Content-Type: application/json');
        echo json_encode(['notes' => $notes]);
    }
} elseif ($action === 'note') {
    $note_id = isset($_GET['noteID']) ? $_GET['noteID'] : '';
    
    $query = 'SELECT * FROM sk_notes WHERE noteID = :note_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':note_id', $note_id);
    $statement->execute();
    $note = $statement->fetch();
    $statement->closeCursor();
    
    if ($format_type === 'xml') {
        // Handle XML response
        header('Content-Type: application/xml');
        echo '<note>';
        echo '<title>' . $note['title'] . '</title>';
        echo '<content>' . $note['content'] . '</content>';
        echo '<tags>' . $note['tags'] . '</tags>';
        echo '</note>';
    } else {
        // Handle JSON response
        header('Content-Type: application/json');
        echo json_encode(['note' => $note]);
    }
} else {
    // Invalid action
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid action']);
}
?>
