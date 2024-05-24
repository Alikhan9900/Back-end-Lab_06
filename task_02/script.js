document.addEventListener('DOMContentLoaded', () => {
    fetchNotes();

    document.getElementById('addNoteButton').addEventListener('click', async () => {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;

        if (title && content) {
            await fetch('add_note.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title, content })
            });

            document.getElementById('title').value = '';
            document.getElementById('content').value = '';
            fetchNotes();
        } else {
            alert('Please fill in both fields');
        }
    });
});

async function fetchNotes() {
    const response = await fetch('get_notes.php');
    const notes = await response.json();

    const notesContainer = document.getElementById('notesContainer');
    notesContainer.innerHTML = '';
    notes.forEach(note => {
        const noteDiv = document.createElement('div');
        noteDiv.classList.add('note');
        noteDiv.innerHTML = `
            <h3>${note.title}</h3>
            <p>${note.content}</p>
            <button onclick="deleteNote(${note.id})">Delete</button>
            <button onclick="editNotePrompt(${note.id}, '${note.title}', '${note.content}')">Edit</button>
        `;
        notesContainer.appendChild(noteDiv);
    });
}

async function deleteNote(id) {
    await fetch('delete_note.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    });

    fetchNotes();
}

async function editNotePrompt(id, oldTitle, oldContent) {
    const newTitle = prompt('New title:', oldTitle);
    const newContent = prompt('New content:', oldContent);

    if (newTitle && newContent) {
        await fetch('update_note.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, title: newTitle, content: newContent })
        });

        fetchNotes();
    } else {
        alert('Both fields are required');
    }
}
