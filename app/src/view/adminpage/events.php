<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Events</title>
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
        <h1>Manage Events</h1>
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Event Name</th>
                    <th>Organization</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="eventsTable">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addEventForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userId" class="form-label">User ID</label>
                        <input type="number" class="form-control" id="userId" name="userId" required>
                    </div>

                    <div class="mb-3">
                        <label for="eventName" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="eventName" name="eventName" required>
                    </div>

                    <div class="mb-3">
                        <label for="artistName" class="form-label">Artist Name</label>
                        <input type="text" class="form-control" id="artistName" name="artistName">
                    </div>

                    <div class="mb-3">
                        <label for="dateFrom" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="dateFrom" name="dateFrom">
                    </div>

                    <div class="mb-3">
                        <label for="dateTo" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="dateTo" name="dateTo">
                    </div>

                    <div class="mb-3">
                        <label for="timeFrom" class="form-label">Time From</label>
                        <input type="time" class="form-control" id="timeFrom" name="timeFrom">
                    </div>

                    <div class="mb-3">
                        <label for="timeTo" class="form-label">Time To</label>
                        <input type="time" class="form-control" id="timeTo" name="timeTo">
                    </div>

                    <div class="mb-3">
                        <label for="locX" class="form-label">Location X</label>
                        <input type="number" step="0.0001" class="form-control" id="locX" name="locX">
                    </div>

                    <div class="mb-3">
                        <label for="locY" class="form-label">Location Y</label>
                        <input type="number" step="0.0001" class="form-control" id="locY" name="locY">
                    </div>

                    <div class="mb-3">
                        <label for="ageLim" class="form-label">Age Limit</label>
                        <input type="number" class="form-control" id="ageLim" name="ageLim">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="number" class="form-control" id="type" name="type">
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="url" class="form-control" id="link" name="link">
                    </div>

                    <div class="mb-3">
                        <label for="online" class="form-label">Online Event</label>
                        <select class="form-select" id="online" name="online">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="urlHash" class="form-label">URL Hash</label>
                        <input type="text" class="form-control" id="urlHash" name="urlHash" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const eventsTable = document.getElementById('eventsTable');

        let events = [
            { id: 1, userId: 101, name: 'Annual Meeting', organization: 'Company A' },
            { id: 2, userId: 102, name: 'Tech Conference', organization: 'Company B' }
        ];

        function loadEvents() {
            eventsTable.innerHTML = '';
            events.forEach(event => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${event.id}</td>
                    <td>${event.userId}</td>
                    <td>${event.name}</td>
                    <td>${event.organization}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editEvent(${event.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteEvent(${event.id})">Delete</button>
                    </td>
                `;
                eventsTable.appendChild(row);
            });
        }

        document.getElementById('addEventForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const newEvent = {
                id: events.length + 1,
                userId: parseInt(this.userId.value),
                name: this.eventName.value,
                organization: this.organization.value
            };
            events.push(newEvent);
            this.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
            modal.hide();
            loadEvents();
        });

        function editEvent(eventId) {
            window.location.href = `fullevent.php?id=${eventId}`;
        }


        function deleteEvent(eventId) {
            events = events.filter(e => e.id !== eventId);
            loadEvents();
        }

        loadEvents();

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
