<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Create New Note</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->
<body>
    <header><h1>Create New Note</h1></header>
    <main>
        <form action="api/create_note.php" method="post" id="create_note_form">
            <label>Title:</label>
            <input type="text" name="title" required><br>
            
            <label>Content:</label>
            <textarea name="content" rows="4" cols="50" required></textarea><br>
            
            <label>Tags:</label>
            <input type="text" name="tags"><br>
            
            <label>&nbsp;</label>
            <input type="submit" value="Create Note"><br>
        </form>
    </main>
</body>
</html>

