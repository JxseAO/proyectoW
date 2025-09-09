document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('calendar');
  if (!calendarEl) return;

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    events: tareas, // viene del index.php
    eventClick: function(info) {
      window.location.href = "tareas/editar.php?id=" + info.event.id;
    }
  });

  calendar.render();
});
