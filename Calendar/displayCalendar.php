
<?php include "../navbar-dashboard.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
</head>
<body>
</style>
<div class="container">
    <h2>Kalender Jadwal</h2>
    <div id='calendar'></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: 'load_events.php', // Endpoint to load events
            dateClick: function(info) {
                var dateStr = prompt('Masukkan deskripsi acara untuk ' + info.dateStr);
                if (dateStr) {
                    // Save event to database
                    fetch('save_event.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            user_id: 1, // Replace with dynamic user ID
                            event_date: info.dateStr,
                            description: dateStr
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Acara berhasil ditambahkan');
                                calendar.refetchEvents(); // Refresh events on calendar
                            } else {
                                alert('Gagal menambahkan acara');
                            }
                        });
                }
            }
        });
        calendar.render();
    });
</script>
</body>
</html>
