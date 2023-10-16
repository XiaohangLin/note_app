<?php
require_once('../database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
    $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);

    if ($title && $content) {
        $query = 'INSERT INTO sk_notes (title, content, tags) VALUES (:title, :content, :tags)';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':tags', $tags);

        if ($statement->execute()) {
            // Set a session message for success
            session_start();
            $_SESSION['success_message'] = 'Note created successfully.';
        } else {
            // Set a session message for error
            session_start();
            $_SESSION['error_message'] = 'Error creating note.';
        }
    } else {
        // Set a session message for missing title/content
        session_start();
        $_SESSION['error_message'] = 'Title and content are required.';
    }

    // Redirect to index.php
    header('Location: ../index.php');
    exit(); // Make sure to exit to prevent further execution
} else {
    // Invalid request method
    $response['success'] = false;
    $response['message'] = 'Invalid request method.';
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
