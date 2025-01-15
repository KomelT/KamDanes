<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include_once("jquery.php");?>
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
        <a href="#" data-redirect="/">Return to site</a>
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
                <form  id="registerUserAdmin" >
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
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="number" class="form-control" id="role" name="role" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="saveUserButton" type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUserForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="number" class="form-control" id="role" name="role" required>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update User</button>
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

        async function loadUsers() {
            userTable.innerHTML = '';
            try {
                const response = await fetch("API/users/getUsers");
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
                console.log(json);
                json.forEach(user => {
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
            } catch (error) {
                console.error(error.message);
            }
            
        }

        function editUser(userId) {
            $.ajax({
                url: 'getUser',
                type: 'post',
                data: { id: userId },
                success:function(user){
                    $('#editUserModal #username').val(user.username);
                    $('#editUserModal #email').val(user.email);
                    $('#editUserModal #password').val(user.password);
                    $('#editUserModal #name').val(user.name);
                    $('#editUserModal #role').val(user.role);
                    $('#editUserModal').modal('show');
                }
            });
        }


        function deleteUser(userId) {
            $.ajax({
                url: 'deleteUser',
                type: 'post',
                data: { id: userId , role: 0},
                success:function(){
                    loadUsers();
                }
            });}
        



        $('#registerUserAdmin').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'registerUserAdmin',
                type: 'post',
                data:$('#registerUserAdmin').serialize(),
                success:function(){
                    loadUsers();
                    $('#addUserModal').modal('hide');
                }
        });
        });


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
