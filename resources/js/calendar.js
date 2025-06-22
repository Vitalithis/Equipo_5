import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        locale: 'es',
        events: '/calendar/events',
        selectable: true,
        dateClick(info) {
            const title = prompt('Título del evento:');
            const type = prompt('Tipo (siembra o transplante):');
            const producto_id = prompt('ID del producto:');

            if (title && type && producto_id) {
                fetch('/calendar/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        title,
                        type,
                        start_date: info.dateStr,
                        producto_id
                    })
                }).then(() => calendar.refetchEvents());
            }
        },
    });

    calendar.render();
});
