document.getElementById('registerForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (name && email && password) {
        const response = await fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, email, password })
        });

        const result = await response.json();
        alert(result.message);
    } else {
        alert('Please fill all fields');
    }
});

document.getElementById('fetchUsers').addEventListener('click', async function () {
    const response = await fetch('users.php');
    const users = await response.json();

    const userList = document.getElementById('userList');
    userList.innerHTML = '';
    users.forEach(user => {
        const listItem = document.createElement('li');
        listItem.textContent = `${user.name} (${user.email})`;

        const editButton = document.createElement('button');
        editButton.textContent = 'Edit';
        editButton.onclick = () => editUser(user.id, user.name, user.email);

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.onclick = () => deleteUser(user.id);

        listItem.appendChild(editButton);
        listItem.appendChild(deleteButton);

        userList.appendChild(listItem);
    });
});

async function deleteUser(userId) {
    const response = await fetch('delete_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userId })
    });

    const result = await response.json();
    alert(result.message);
    document.getElementById('fetchUsers').click();
}

async function editUser(userId, currentName, currentEmail) {
    const newName = prompt('Enter new name:', currentName);
    const newEmail = prompt('Enter new email:', currentEmail);

    if (newName && newEmail) {
        const response = await fetch('edit_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userId, name: newName, email: newEmail })
        });

        const result = await response.json();
        alert(result.message);
        document.getElementById('fetchUsers').click();
    } else {
        alert('All fields are required');
    }
}

