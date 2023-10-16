document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to "Delete" buttons
    var deleteButtons = document.querySelectorAll('.delete-note');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var noteId = button.getAttribute('data-note-id');
            deleteNote(noteId);
        });
    });

    // event listeners to "Edit" buttons
    var editButtons = document.querySelectorAll('.edit-note');
    console.log("added edit");
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var noteId = button.getAttribute('data-note-id');
            window.location.href = 'views/edit_note_form.php?noteID=' + noteId;
        });
    });

        // Function to show content
        function showContent(content) {
            alert(content); // You can customize this to display content in a more user-friendly way
        }
    //display filter notes
    filterNotes();

});

// Function to filter notes by tag
function filterNotes() {
    var tagFilter = document.getElementById('tagFilter');
    var selectedTag = tagFilter.value;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'api/get_note.php?tag=' + encodeURIComponent(selectedTag), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var notes = JSON.parse(xhr.responseText);
                updateNoteTable(notes); // Call function to update UI with filtered notes
            } else {
                // Handle error here
                console.error('Error fetching filtered notes:', xhr.responseText);
            }
        }
    };
    xhr.send();
}
    // Function to delete a note using API
    function deleteNote(noteId) {
        if (confirm('Are you sure you want to delete this note?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'api/delete_note.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Note deleted successfully, you can update UI here
                        location.reload(); // Refresh the page to reflect changes
                    } else {
                        // Handle error here
                        console.error('Error deleting note:', xhr.responseText);
                    }
                }
            };
            xhr.send('note_id=' + encodeURIComponent(noteId));
        }
    }

// Function to update note table with filtered notes
function updateNoteTable(notesObject) {
    var tableBody = document.getElementById('noteTableBody');
    tableBody.innerHTML = ''; // Clear existing table rows

    var notesArray = Object.values(notesObject.notes); // Convert the notes object to an array

    notesArray.forEach(function(note) {
        var newRow = tableBody.insertRow();
        var titleCell = newRow.insertCell(0);
        var tagsCell = newRow.insertCell(1);
        var createdAtCell = newRow.insertCell(2);
        var actionsCell = newRow.insertCell(3);

        titleCell.textContent = note.title;
        tagsCell.textContent = note.tags;
        createdAtCell.textContent = note.created_at;

        var contentRow = tableBody.insertRow(); // Create a new row for the content
        contentRow.style.display = 'none'; // Hide the content row by default
        var contentCell = contentRow.insertCell(0);
        contentCell.colSpan = 4; // Set colspan to cover all columns
        contentCell.classList.add('content-cell'); // Add a class for styling

        // note content
        var contentTextarea = document.createElement('textarea'); 
        contentTextarea.classList.add('note-content');
        contentTextarea.textContent = note.content;
        contentCell.appendChild(contentTextarea);

        //"Show Content" button
        var showContentButton = document.createElement('button'); 
        showContentButton.classList.add('show-content');
        showContentButton.textContent = 'Show Content';
        actionsCell.appendChild(showContentButton);

        showContentButton.addEventListener('click', function() {
            var isHidden = contentRow.style.display === 'none';
            contentRow.style.display = isHidden ? 'table-row' : 'none';
        });
        //"edit" button
        var editButton = document.createElement('button'); // Create the "Edit" button
        editButton.classList.add('edit-note');
        editButton.setAttribute('data-note-id', note.noteID);
        editButton.textContent = 'Edit';
        actionsCell.appendChild(editButton);

        editButton.addEventListener('click', function() {
            window.location.href = 'views/edit_note_form.php?noteID=' + note.noteID;
        });

        //"Delete" button
        var deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-note');
        deleteButton.setAttribute('data-note-id', note.noteID);
        deleteButton.textContent = 'Delete';
        actionsCell.appendChild(deleteButton);
        deleteButton.addEventListener('click', function() {
            deleteNote(note.noteID);
        });
        
    });
}



