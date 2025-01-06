
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Details</title>
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
            <a href="users.php">Manage Users</a>                
            <a href="events.php">Manage Events</a>
        </div>

        <div id="main-content">
            <h1>Event Details</h1>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($event['id']); ?></td>
                </tr>
                <tr>
                    <th>User ID</th>
                    <td><?php echo htmlspecialchars($event['id_user']); ?></td>
                </tr>
                <tr>
                    <th>Event Name</th>
                    <td><?php echo htmlspecialchars($event['name']); ?></td>
                </tr>
                <tr>
                    <th>Organization</th>
                    <td><?php echo htmlspecialchars($event['organisation']); ?></td>
                </tr>
                <tr>
                    <th>Artist Name</th>
                    <td><?php echo htmlspecialchars($event['artist_name']); ?></td>
                </tr>
                <tr>
                    <th>Date From</th>
                    <td><?php echo htmlspecialchars($event['date_from']); ?></td>
                </tr>
                <tr>
                    <th>Date To</th>
                    <td><?php echo htmlspecialchars($event['date_to']); ?></td>
                </tr>
                <tr>
                    <th>Time From</th>
                    <td><?php echo htmlspecialchars($event['time_from']); ?></td>
                </tr>
                <tr>
                    <th>Time To</th>
                    <td><?php echo htmlspecialchars($event['time_to']); ?></td>
                </tr>
                <tr>
                    <th>Location X</th>
                    <td><?php echo htmlspecialchars($event['loc_x']); ?></td>
                </tr>
                <tr>
                    <th>Location Y</th>
                    <td><?php echo htmlspecialchars($event['loc_y']); ?></td>
                </tr>
                <tr>
                    <th>Age Limit</th>
                    <td><?php echo htmlspecialchars($event['age_lim']); ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?php echo nl2br(htmlspecialchars($event['description'])); ?></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><?php echo htmlspecialchars($event['price']); ?></td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td><?php echo htmlspecialchars($event['type']); ?></td>
                </tr>
                <tr>
                    <th>Link</th>
                    <td><a href="<?php echo htmlspecialchars($event['link']); ?>" target="_blank">Event Link</a></td>
                </tr>
                <tr>
                    <th>Online Event</th>
                    <td><?php echo $event['online'] ? 'Yes' : 'No'; ?></td>
                </tr>
                <tr>
                    <th>URL Hash</th>
                    <td><?php echo htmlspecialchars($event['url_hash']); ?></td>
                </tr>
            </table>
            <a href="events.php" class="btn btn-secondary">Back to Event List</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
