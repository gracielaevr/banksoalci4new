<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const events = <?= $events ?>;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },
        initialView: 'dayGridMonth',
        events: events,
        eventContent: function(info) {
            // Mengatur konten event dengan HTML kustom
            return {
                html: `<div style="text-align:center; background-color: ${info.event.backgroundColor}; padding: 5px; border-radius: 5px;">
                    <strong>${info.event.title}</strong><br>
                    <span>${info.event.extendedProps.description}</span>
                </div>`
            };
        },
        eventDidMount: function(info) {
            // Menyesuaikan warna latar belakang elemen event
            info.el.style.backgroundColor = info.event.backgroundColor;

            info.el.style.cursor = 'pointer';
        },
        eventClick: function(info) {
            // Mencegah tindakan default
            info.jsEvent.preventDefault();

            // Arahkan ke halaman detail berdasarkan ID event
            // const konsultasiId = info.event.id;
            window.location.href = 'datasiswa';
        }
    });

    calendar.render();
});
</script>

<section class="section">
    <div class="row-btn">
        <ol class="breadcrumb bg-white d-flex align-items-end">
            <h5 class="me-1 mb-0">Jadwal Konsultasi</h5><small>Konsultasi</small>
        </ol>
    </div>
    <div class="card shadow-leap p-3">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</section>