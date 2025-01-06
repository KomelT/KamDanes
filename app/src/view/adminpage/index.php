<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/leaflet-sidebar-v2@0.2.0/dist/leaflet-sidebar.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <div id="admin-sidebar">
        <h3 class="text-center py-3">Admin Panel</h3>
        <a href="#" data-redirect="users.php">Manage Users</a>
        <a href="#" data-redirect="events.php">Manage Events</a>
    </div>

    <div id="main-content">
        <h1>Welcome to the Admin Panel</h1>
        <section id="login"></section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
