<?php
require_once('../database.php');

$response = array(); // Initialize response array

$tag = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING);
if ($tag) {
    $query = 'SELECT * FROM sk_notes WHERE tags LIKE :tag ORDER BY created_at DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':tag', '%' . $tag . '%');
} else {
    $query = 'SELECT * FROM sk_notes ORDER BY created_at DESC';
    $statement = $db->prepare($query);
}

if ($statement->execute()) {
    $notes = $statement->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true;
    $response['message'] = 'Notes fetched successfully.';
    $response['notes'] = $notes;
} else {
    $response['success'] = false;
    $response['message'] = 'Error fetching notes.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
