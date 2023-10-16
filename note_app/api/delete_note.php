<?php
require_once('../database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    
    if ($note_id !== false) {
        // Delete the note from the database
        $query = 'DELETE FROM sk_notes WHERE noteID = :note_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':note_id', $note_id);
        $statement->execute();
        // You can return success or error message if needed
        echo 'Note deleted successfully';
    } else {
        // Handle invalid input
        header('HTTP/1.1 400 Bad Request');
        echo 'Invalid note ID';
    }
}
?>
