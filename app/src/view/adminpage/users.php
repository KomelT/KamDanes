<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #admin-sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            background: #343a40;
            color: #fff;
            overflow-y: auto;
            z-index: 1000;
        }
        #admin-sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        #admin-sidebar a:hover {
            background: #495057;
        }
        #main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .modal-dialog {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div id="admin-sidebar">
        <h3 class="text-center py-3">Admin Panel</h3>
        <a href="#" data-redirect="adminusers">Manage Users</a>
        <a href="#" data-redirect="adminevents">Manage Events</a>
    </div>

    <div id="main-content">
        <h1>Manage Users</h1>
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addUserForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="1">Admin</option>
                                <option value="2">Editor</option>
                                <option value="3">Viewer</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const userTable = document.getElementById('userTable');

        let users = [
            { id: 1, username: 'admin', email: 'admin@example.com', name: 'Admin User', phone: '1234567890', role: 'Admin' },
            { id: 2, username: 'editor', email: 'editor@example.com', name: 'Editor User', phone: '0987654321', role: 'Editor' }
        ];

        function loadUsers() {
            userTable.innerHTML = '';
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.name}</td>
                    <td>${user.phone}</td>
                    <td>${user.role}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                `;
                userTable.appendChild(row);
            });
        }

        document.getElementById('addUserForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const newUser = {
                id: users.length + 1,
                username: this.username.value,
                email: this.email.value,
                name: this.name.value,
                phone: this.phone.value,
                role: this.role.options[this.role.selectedIndex].text
            };
            users.push(newUser);
            this.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            loadUsers();
        });

        function editUser(userId) {
            const user = users.find(u => u.id === userId);
            if (user) {
                alert(`Edit User: ${user.name} - Implement edit functionality`);
            }
        }

        function deleteUser(userId) {
            users = users.filter(u => u.id !== userId);
            loadUsers();
        }

        loadUsers();

        document.querySelectorAll('#admin-sidebar a').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault(); 
                const redirectUrl = this.getAttribute('data-redirect');
                if (redirectUrl) {
                    window.location.href = redirectUrl; 
                }
            });
        });
    </script>
</body>
</html>
