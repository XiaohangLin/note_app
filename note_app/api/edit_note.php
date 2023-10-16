<?php
require_once('../database.php');

$response = array(); // Initialize response array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
    $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);

    if ($note_id !== false && $title && $content) {
        $query = 'UPDATE sk_notes SET title = :title, content = :content, tags = :tags WHERE noteID = :note_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':tags', $tags);
        $statement->bindValue(':note_id', $note_id);
        
        if ($statement->execute()) {
            $response['success'] = true;
            $response['message'] = 'Note updated successfully.';

        } else {
            $response['success'] = false;
            $response['message'] = 'Error updating note.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid note ID, title, or content.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);

header('Location: ../index.php');
exit;
?>
