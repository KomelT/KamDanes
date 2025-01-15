<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Events</title>
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
        <h1>Manage Events</h1>
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Event Name</th>
                    <th>Link</th>
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
            <form id="addEventForm" >
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <label for="name">Ime dogodka</label><br>
            <input class="form-control form-control-sm" type="text" name="name" id="name" required><br>

            <label for="organisation">Organizacija</label> <br>
            <input class="form-control form-control-sm" type="text" name="organisation" id="organisation"><br>

            <label for="artist_name">Ime umetnika</label> <br>
            <input class="form-control form-control-sm" type="text" name="artist_name" id="artist_name"><br>
            
            <label for="date_from">Datum od</label> <br>
            <input class="form-control form-control-sm" type="date" name="date_from" id="date_from" required><br>

            <label for="date_to">Datum do</label> <br>
            <input class="form-control form-control-sm" type="date" name="date_to" id="date_to" required><br>

            <input class="form-check-input" type="checkbox" name="online" id="online-input">
            <label class="form-check-label" for="online">Online dogodek</label> <br><br>

            <label for="address">Ulica</label> <br>
            <input class="form-control form-control-sm" type="text" name="street" id="street-input" required><br>

            <label for="city">Mesto</label> <br>
            <input class="form-control form-control-sm" type="text" name="city" id="city-input" required><br>

            <label for="zip">Poštna številka</label> <br>
            <input class="form-control form-control-sm" type="text" name="zip" id="zip-input" required><br>

            <label for="time_from">Ura začetka</label><br>
            <input class="form-control form-control-sm" type="time" name="time_from" id="time_from"><br>

            <label for="time_to">Ura konca</label><br>
            <input class="form-control form-control-sm" type="time" name="time_to" id="time_to"><br>

            <input class="form-check-input" type="checkbox" name="age_lim_bool" id="age_lim_bool-input">
            <label class="form-check-label" for="age_lim_bool">Starostna omejitev</label> <br><br>

            <label for="age_lim">Minimalna starost v letih</label><br>
            <input class="form-control form-control-sm" type="number" name="age_lim" id="age_lim" disabled><br>

            <label for="description">Opis</label><br>
            <textarea class="form-control" name="description" id=""description></textarea><br>

            <input class="form-check-input" type="checkbox" name="cena_bool" id="cena_bool-input" checked>
            <label class="form-check-label" for="cena_bool">Brezplačen dogodek</label> <br><br>

            <label for="price">Cena</label><br>
            <input class="form-control form-control-sm" type="number" name="price" id="price" disabled><br>

            <label for="type">Tip dogodka</label><br>
            <select class="form-select" name="type" id="type">
              <option value="0">UL Dogodek</option>
              <option value="1">Kulturni dogodek</option>
              <option value="2">Zabava</option>
              <option value="3">Izobraževanje</option>
              <option value="4">Dobrodelnost</option>
              <option value="5">Šport</option>
              <option value="6" selected>Ostalo</option>
            </select><br>
            
            <label for="link">Link do dogodka</label><br>
            <input class="form-control form-control-sm" type="text" name="link" id="link" required><br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editEventForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="name">Ime dogodka</label><br>
                    <input type="hidden" name="id" id="id">
                    <input class="form-control form-control-sm" type="text" name="name" id="name" required><br>

                    <label for="organisation">Organizacija</label> <br>
                    <input class="form-control form-control-sm" type="text" name="organisation" id="organisation"><br>

                    <label for="artist_name">Ime umetnika</label> <br>
                    <input class="form-control form-control-sm" type="text" name="artist_name" id="artist_name"><br>
                    
                    <label for="date_from">Datum od</label> <br>
                    <input class="form-control form-control-sm" type="date" name="date_from" id="date_from" required><br>

                    <label for="date_to">Datum do</label> <br>
                    <input class="form-control form-control-sm" type="date" name="date_to" id="date_to" required><br>

                    <input class="form-check-input" type="checkbox" name="online" id="online-input">
                    <label class="form-check-label" for="online">Online dogodek</label> <br><br>

                    <label for="address">Ulica</label> <br>
                    <input class="form-control form-control-sm" type="text" name="street" id="street-input"><br>

                    <label for="city">Mesto</label> <br>
                    <input class="form-control form-control-sm" type="text" name="city" id="city-input"><br>

                    <label for="zip">Poštna številka</label> <br>
                    <input class="form-control form-control-sm" type="text" name="zip" id="zip-input"><br>

                    <label for="time_from">Ura začetka</label><br>
                    <input class="form-control form-control-sm" type="time" name="time_from" id="time_from"><br>

                    <label for="time_to">Ura konca</label><br>
                    <input class="form-control form-control-sm" type="time" name="time_to" id="time_to"><br>

                    <input class="form-check-input" type="checkbox" name="age_lim_bool" id="age_lim_bool-input">
                    <label class="form-check-label" for="age_lim_bool">Starostna omejitev</label> <br><br>

                    <label for="age_lim">Minimalna starost v letih</label><br>
                    <input class="form-control form-control-sm" type="number" name="age_lim" id="age_lim" disabled><br>

                    <label for="description">Opis</label><br>
                    <textarea class="form-control" name="description" id=""description></textarea><br>

                    <input class="form-check-input" type="checkbox" name="cena_bool" id="cena_bool-input" checked>
                    <label class="form-check-label" for="cena_bool">Brezplačen dogodek</label> <br><br>

                    <label for="price">Cena</label><br>
                    <input class="form-control form-control-sm" type="number" name="price" id="price" disabled><br>

                    <label for="type">Tip dogodka</label><br>
                    <select class="form-select" name="type" id="type">
                    <option value="0">Univerza v Ljubljani Dogodek</option>
                    <option value="1">Kulturni dogodek</option>
                    <option value="2">Zabava</option>
                    <option value="3">Izobraževanje</option>
                    <option value="4">Dobrodelnost</option>
                    <option value="5">Šport</option>
                    <option value="6" selected>Ostalo</option>
                    </select><br>
                    
                    <label for="link">Link do dogodka</label><br>
                    <input class="form-control form-control-sm" type="text" name="link" id="link" required><br>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const eventsTable = document.getElementById('eventsTable');

        let events = [
           
        ];

        async function loadEvents() {
            eventsTable.innerHTML = '';
            try {
                const response = await fetch("API/events/all");
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
                //console.log(json);
                json.forEach(event => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${event.id}</td>
                    <td>${event.id_user}</td>
                    <td>${event.name}</td>
                    <td><a href="${event.link}" target="_blank">${event.link}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editEvent(${event.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteEvent(${event.id})">Delete</button>
                    </td>
                `;
                eventsTable.appendChild(row);
            });
            } catch (error) {
                console.error(error.message);
            }
            
        }

        $('#addEventForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'addEventForm',
                type: 'POST',
                data:$('#addEventForm').serialize(),
                success:function(){
                    loadEvents();
                    $('#addEventModal').modal('hide');
                }

            });
        });

        

        $("#editEventForm").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'updateEvents',
                    type: 'POST',
                    data: formData,
                    success: function() {
                        loadEvents();
                        
                        $('#editEventModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating event:', error);
                        console.error('Error updating event:', xhr);
                        

                    }
                });
                
            });
        function editEvent(eventId) {
            $.ajax({
                url: 'API/events/eventDetail',
                data: {id: eventId},
                method: 'POST',
                success: function(event) {
                    //console.log(event);
                    var modal = $('#editEventModal');
                    modal.find('#id').val(event.id);
                    modal.find('#name').val(event.name);
                    modal.find('#organisation').val(event.organisation);
                    modal.find('#artist_name').val(event.artist_name);
                    modal.find('#date_from').val(event.date_from);
                    modal.find('#date_to').val(event.date_to);
                    modal.find('#online-input').prop('checked', event.online);
                    modal.find('#time_from').val(event.time_from);
                    modal.find('#time_to').val(event.time_to);
                    modal.find('#age_lim_bool-input').prop('checked', event.age_lim_bool);
                    modal.find('#age_lim').val(event.age_lim);
                    modal.find('#description').val(event.description);
                    modal.find('#cena_bool-input').prop('checked', event.cena_bool);
                    modal.find('#price').val(event.price);
                    modal.find('#type').val(event.type);
                    modal.find('#link').val(event.link);
                    modal.find('#age_lim').prop('disabled', !event.age_lim_bool);
                    modal.find('#price').prop('disabled', event.cena_bool);
                    $('#editEventModal').modal('show');

                    
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching event details:', error);
                }
            });
        }

        
            
        
        function deleteEvent(eventId) {
            $.ajax({
                url: 'API/events/delete',
                method: 'POST',
                data: {
                    id: eventId,
                },
                success: function(response) {
                    console.log('Event deleted successfully');
                    loadEvents();
                                    },
                error: function(xhr, status, error) {
                    console.error('Error deleting event:', error);
                    
                }
            })
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
        document.getElementById("age_lim_bool-input").addEventListener("change", function() {
        if (this.checked) {
        document.getElementById("age_lim").disabled = false;
        } else {
        document.getElementById("age_lim").disabled = true;
        }
         });

        document.getElementById("cena_bool-input").addEventListener("change", function() {
        if (this.checked) {
        document.getElementById("price").disabled = true;
        } else {
        document.getElementById("price").disabled = false;
        }
        document.getElementById("clearButton").addEventListener("click", function(){
        document.getElementById("addEventForm").reset()
        document.getElementById("street-input").disabled = false;
        document.getElementById("city-input").disabled = false;
        document.getElementById("zip-input").disabled = false;
        document.getElementById("age_lim").disabled = true;
        document.getElementById("price").disabled = true;
        });
        });

    </script>
</body>
</html>
