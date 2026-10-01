<?= $this->extend('Modules\Website\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
/* ===== CALENDAR PAGE ===== */
:root {
    --gold: #C8A34D;
    --gold-light: rgba(200,163,77,0.10);
    --gold-gradient: linear-gradient(135deg, #C8A34D, #E8C56A);
    --royal: #1E4FA3;
    --royal-light: rgba(30,79,163,0.08);
    --dark: #121212;
    --gray: #6B7280;
    --white: #FFFFFF;
}

/* Hero */
.cal-hero {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1b3e 60%, #121212 100%);
    padding: 110px 0 56px;
    position: relative;
    overflow: hidden;
}
.cal-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 50% 70% at 85% 50%, rgba(200,163,77,0.07) 0%, transparent 60%);
}
.cal-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 18px;
    background: rgba(200,163,77,0.12);
    border: 1px solid rgba(200,163,77,0.25);
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #C8A34D;
    margin-bottom: 18px;
}
.cal-hero-title {
    font-size: clamp(30px, 4.5vw, 56px);
    font-weight: 900;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 14px;
}
.cal-hero-title span { color: #C8A34D; }
.cal-hero-subtitle {
    font-size: 16px;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
    max-width: 500px;
}

/* Main section */
.cal-main {
    padding: 56px 0 80px;
    background: #f8f9fa;
}

/* Calendar wrapper */
.cal-card {
    background: #fff;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.07);
    border: 1px solid rgba(0,0,0,0.06);
}

/* View switcher */
.cal-view-switcher {
    display: flex;
    gap: 4px;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 4px;
}
.cal-view-btn {
    flex: 1;
    padding: 8px 16px;
    border: none;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
    background: transparent;
    cursor: pointer;
    transition: all 0.25s;
    white-space: nowrap;
}
.cal-view-btn.active {
    background: #fff;
    color: #C8A34D;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* Nav buttons */
.cal-nav-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid rgba(0,0,0,0.1);
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #374151;
    font-size: 14px;
    transition: all 0.2s;
}
.cal-nav-btn:hover {
    background: #C8A34D;
    border-color: #C8A34D;
    color: #fff;
}
.cal-month-title {
    font-size: 18px;
    font-weight: 800;
    color: #121212;
    min-width: 180px;
    text-align: center;
}

/* FullCalendar custom styles */
#trainingCalendar .fc {
    font-family: 'Inter', sans-serif;
}
#trainingCalendar .fc-toolbar-title {
    font-size: 18px;
    font-weight: 800;
    color: #121212;
}
#trainingCalendar .fc-button-primary {
    background: transparent;
    border: 1.5px solid rgba(0,0,0,0.12);
    color: #374151;
    font-weight: 600;
    font-size: 13px;
    border-radius: 10px !important;
    padding: 7px 14px;
    transition: all 0.2s;
}
#trainingCalendar .fc-button-primary:hover,
#trainingCalendar .fc-button-primary:not(:disabled):active,
#trainingCalendar .fc-button-primary:not(:disabled).fc-button-active {
    background: #C8A34D !important;
    border-color: #C8A34D !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(200,163,77,0.35) !important;
}
#trainingCalendar .fc-button-primary:focus { box-shadow: none !important; }
#trainingCalendar .fc-today-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
#trainingCalendar .fc-col-header-cell-cushion {
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6B7280;
    text-decoration: none;
    padding: 10px 4px;
}
#trainingCalendar .fc-daygrid-day-number {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    text-decoration: none;
    padding: 6px 10px;
}
#trainingCalendar .fc-daygrid-day.fc-day-today {
    background: rgba(200,163,77,0.07) !important;
}
#trainingCalendar .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
    background: #C8A34D;
    color: #fff;
    border-radius: 8px;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#trainingCalendar .fc-event {
    border-radius: 6px;
    border: none !important;
    padding: 2px 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s;
}
#trainingCalendar .fc-event:hover { opacity: 0.85; }
#trainingCalendar .fc-daygrid-event-harness { margin-bottom: 2px; }
#trainingCalendar .fc-list-event-title a {
    color: inherit;
    text-decoration: none;
    font-weight: 600;
}
#trainingCalendar .fc-list-day-cushion {
    background: rgba(200,163,77,0.06) !important;
    font-weight: 700;
    color: #121212;
}
#trainingCalendar .fc-list-event:hover td { background: rgba(200,163,77,0.04); }
#trainingCalendar .fc-theme-standard td,
#trainingCalendar .fc-theme-standard th { border-color: rgba(0,0,0,0.06); }
#trainingCalendar .fc-theme-standard .fc-scrollgrid { border-color: rgba(0,0,0,0.06); }

/* Sidebar */
.cal-sidebar {
    position: sticky;
    top: 80px;
}
.cal-sidebar-card {
    background: #fff;
    border-radius: 20px;
    padding: 22px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 2px 16px rgba(0,0,0,0.05);
    margin-bottom: 16px;
}
.cal-sidebar-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #9CA3AF;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.cal-sidebar-title i { color: #C8A34D; }

/* Upcoming training item */
.upcoming-item {
    display: flex;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid #f3f4f6;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.upcoming-item:last-child { border-bottom: none; padding-bottom: 0; }
.upcoming-item:hover { padding-left: 4px; }
.upcoming-date-box {
    width: 44px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
}
.upcoming-date-box .day {
    font-size: 20px;
    font-weight: 900;
    line-height: 1;
}
.upcoming-item-title {
    font-size: 13px;
    font-weight: 700;
    color: #121212;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 4px;
}
.upcoming-item-meta {
    font-size: 11px;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Legend */
.legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #374151;
    margin-bottom: 8px;
}
.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 4px;
    flex-shrink: 0;
}

/* Event popup modal */
.event-modal .modal-content {
    border-radius: 24px;
    border: none;
    overflow: hidden;
    box-shadow: 0 24px 80px rgba(0,0,0,0.2);
}
.event-modal .modal-header {
    background: linear-gradient(135deg, #0a0a1a, #0d1b3e);
    color: #fff;
    border: none;
    padding: 24px 28px 20px;
}
.event-modal .modal-title { font-weight: 900; font-size: 18px; color: #fff; }
.event-modal .btn-close { filter: invert(1) opacity(0.7); }
.event-modal .modal-body { padding: 28px; }
.event-modal-meta {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
}
.event-modal-meta-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14px;
    color: #374151;
}
.event-modal-meta-item i {
    width: 18px;
    color: #C8A34D;
    font-size: 15px;
    flex-shrink: 0;
    margin-top: 2px;
}
.event-modal-price {
    font-size: 28px;
    font-weight: 900;
    color: #C8A34D;
    padding: 16px 20px;
    background: rgba(200,163,77,0.07);
    border-radius: 16px;
    display: flex;
    align-items: baseline;
    gap: 6px;
    margin-bottom: 20px;
}
.event-modal-price span:first-child { font-size: 14px; font-weight: 600; color: #9CA3AF; }
.event-modal-wa-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px 24px;
    border-radius: 14px;
    background: linear-gradient(135deg, #C8A34D, #E8C56A);
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 6px 24px rgba(200,163,77,0.4);
    text-decoration: none;
}
.event-modal-wa-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 32px rgba(200,163,77,0.5);
    color: #fff;
}
.event-modal-detail-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px 24px;
    border-radius: 14px;
    background: transparent;
    border: 1.5px solid rgba(30,79,163,0.25);
    color: #1E4FA3;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    text-decoration: none;
    margin-top: 10px;
}
.event-modal-detail-btn:hover {
    background: #1E4FA3;
    color: #fff;
}

@media (max-width: 991px) {
    .cal-sidebar { position: static; margin-top: 24px; }
}
@media (max-width: 768px) {
    .cal-card { padding: 16px; }
    .cal-hero { padding: 90px 0 44px; }
}
</style>

<!-- FullCalendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<!-- ====== HERO ====== -->
<section class="cal-hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" style="color:rgba(255,255,255,0.5); text-decoration:none; font-size:13px;">
                                <i class="fas fa-home me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= site_url('pelatihan') ?>" style="color:rgba(255,255,255,0.5); text-decoration:none; font-size:13px;">Pelatihan</a>
                        </li>
                        <li class="breadcrumb-item active" style="color:rgba(255,255,255,0.75); font-size:13px;">Kalender</li>
                    </ol>
                </nav>

                <div class="cal-hero-badge" data-aos="fade-down">
                    <i class="fas fa-calendar-alt"></i>
                    Jadwal Pelatihan
                </div>
                <h1 class="cal-hero-title" data-aos="fade-up" data-aos-delay="100">
                    Kalender <span>Jadwal</span><br>Pelatihan BKC
                </h1>
                <p class="cal-hero-subtitle" data-aos="fade-up" data-aos-delay="150">
                    Pantau jadwal seluruh program pelatihan kami dalam tampilan kalender interaktif. Klik event untuk detail dan pendaftaran.
                </p>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end" data-aos="fade-left" data-aos-delay="200">
                <div style="font-size:160px; color:rgba(200,163,77,0.08); line-height:1; user-select:none;">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== CALENDAR MAIN ====== -->
<section class="cal-main">
    <div class="container">
        <div class="row g-4 align-items-start">

            <!-- Calendar -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="cal-card">

                    <!-- View switcher & legend -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                        <div>
                            <div style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#9CA3AF; margin-bottom:4px;">Tampilan</div>
                            <div class="cal-view-switcher">
                                <button class="cal-view-btn active" data-view="dayGridMonth">
                                    <i class="fas fa-th me-1"></i>Bulan
                                </button>
                                <button class="cal-view-btn" data-view="timeGridWeek">
                                    <i class="fas fa-calendar-week me-1"></i>Minggu
                                </button>
                                <button class="cal-view-btn" data-view="listMonth">
                                    <i class="fas fa-list me-1"></i>Daftar
                                </button>
                            </div>
                        </div>
                        <div style="font-size:12px; color:#9CA3AF;">
                            <i class="fas fa-hand-pointer me-1" style="color:#C8A34D;"></i>
                            Klik event untuk detail
                        </div>
                    </div>

                    <!-- Calendar container -->
                    <div id="trainingCalendar"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="cal-sidebar">

                    <!-- Quick Actions -->
                    <div class="cal-sidebar-card">
                        <div class="cal-sidebar-title">
                            <i class="fas fa-bolt"></i> Aksi Cepat
                        </div>
                        <a href="<?= site_url('pelatihan') ?>"
                           style="display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; background:rgba(200,163,77,0.07); border:1px solid rgba(200,163,77,0.2); text-decoration:none; color:#C8A34D; font-weight:700; font-size:14px; margin-bottom:10px;">
                            <i class="fas fa-th-large"></i> Semua Pelatihan
                            <i class="fas fa-chevron-right ms-auto" style="font-size:11px;"></i>
                        </a>
                        <a href="<?= site_url('pelatihan/inhouse') ?>"
                           style="display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; background:rgba(30,79,163,0.06); border:1px solid rgba(30,79,163,0.15); text-decoration:none; color:#1E4FA3; font-weight:700; font-size:14px;">
                            <i class="fas fa-building"></i> Request In-House
                            <i class="fas fa-chevron-right ms-auto" style="font-size:11px;"></i>
                        </a>
                    </div>

                    <!-- Upcoming Trainings -->
                    <?php if (!empty($upcomingTrainings)): ?>
                    <div class="cal-sidebar-card">
                        <div class="cal-sidebar-title">
                            <i class="fas fa-clock"></i> Jadwal Terdekat
                        </div>
                        <?php foreach ($upcomingTrainings as $ut): ?>
                        <?php
                        $utColor = $ut['category_color'] ?? '#C8A34D';
                        $utDate = !empty($ut['start_date']) ? strtotime($ut['start_date']) : null;
                        ?>
                        <a href="<?= site_url('pelatihan/' . esc($ut['slug'])) ?>"
                           class="upcoming-item">
                            <div class="upcoming-date-box"
                                 style="background:<?= esc($utColor) ?>18; color:<?= esc($utColor) ?>;">
                                <span class="day"><?= $utDate ? date('d', $utDate) : '--' ?></span>
                                <span><?= $utDate ? date('M', $utDate) : '' ?></span>
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div class="upcoming-item-title"><?= esc($ut['title']) ?></div>
                                <div class="upcoming-item-meta">
                                    <i class="fas fa-map-marker-alt" style="color:<?= esc($utColor) ?>;"></i>
                                    <?= esc($ut['location_city'] ?? $ut['location_name'] ?? 'Bali') ?>
                                    <?php if (!empty($ut['price']) && $ut['price'] > 0): ?>
                                    &nbsp;&bull;&nbsp;
                                    <span style="color:<?= esc($utColor) ?>; font-weight:700;">Rp <?= number_format($ut['price'], 0, ',', '.') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Legend (will be populated dynamically) -->
                    <div class="cal-sidebar-card" id="calLegend">
                        <div class="cal-sidebar-title">
                            <i class="fas fa-tag"></i> Kategori
                        </div>
                        <div id="legendItems">
                            <!-- populated by JS -->
                            <div class="legend-item">
                                <div class="legend-dot" style="background:#C8A34D;"></div>
                                <span>Memuat kategori...</span>
                            </div>
                        </div>
                    </div>

                    <!-- WA Contact -->
                    <div style="background:linear-gradient(135deg,#0a0a1a,#0d1b3e); border-radius:20px; padding:22px; text-align:center;">
                        <div style="font-size:28px; color:#C8A34D; margin-bottom:12px;"><i class="fab fa-whatsapp"></i></div>
                        <div style="font-weight:800; color:#fff; margin-bottom:6px;">Ada Pertanyaan?</div>
                        <div style="font-size:13px; color:rgba(255,255,255,0.5); margin-bottom:18px;">Konsultasi jadwal pelatihan gratis bersama tim BKC.</div>
                        <a href="https://wa.me/<?= esc($profile['whatsapp'] ?? '6281803867430') ?>?text=<?= urlencode('Halo BKC, saya ingin tanya jadwal pelatihan terdekat.') ?>"
                           target="_blank" rel="noopener"
                           style="display:inline-flex; align-items:center; gap:8px; padding:11px 22px; border-radius:100px; background:linear-gradient(135deg,#C8A34D,#E8C56A); color:#fff; font-weight:700; font-size:14px; text-decoration:none;">
                            <i class="fab fa-whatsapp"></i> Chat Sekarang
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Event Detail Modal -->
<div class="modal fade event-modal" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="eventModalHeader">
                <h5 class="modal-title" id="eventModalTitle">Detail Pelatihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="event-modal-meta" id="eventModalMeta">
                    <div class="event-modal-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="eventModalDate">-</span>
                    </div>
                    <div class="event-modal-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span id="eventModalLocation">-</span>
                    </div>
                    <div class="event-modal-meta-item">
                        <i class="fas fa-tag"></i>
                        <span id="eventModalCategory">-</span>
                    </div>
                    <div class="event-modal-meta-item" id="eventModalQuotaWrap" style="display:none;">
                        <i class="fas fa-users"></i>
                        <span id="eventModalQuota">-</span>
                    </div>
                </div>

                <div class="event-modal-price" id="eventModalPriceWrap">
                    <span>Investasi</span>
                    <span id="eventModalPrice">-</span>
                </div>

                <button type="button" class="event-modal-wa-btn" id="eventModalWaBtn" onclick="">
                    <i class="fab fa-whatsapp" style="font-size:20px;"></i>
                    Daftar via WhatsApp
                </button>

                <a href="#" class="event-modal-detail-btn" id="eventModalDetailBtn">
                    <i class="fas fa-eye"></i> Lihat Detail Lengkap
                </a>

            </div>
        </div>
    </div>
</div>

<script>
// Calendar events from controller
const calEvents = <?= json_encode($events ?? [], JSON_HEX_TAG | JSON_HEX_AMP) ?>;

// Track seen categories for legend
const categoryColors = {};

document.addEventListener('DOMContentLoaded', function () {

    const calEl = document.getElementById('trainingCalendar');
    if (!calEl) return;

    const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));

    const calendar = new FullCalendar.Calendar(calEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        buttonText: {
            today: 'Hari ini',
            month: 'Bulan',
            week: 'Minggu',
            list: 'Daftar'
        },
        events: calEvents,
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            showEventModal(info.event);
        },
        eventDidMount: function(info) {
            // Track category colors for legend
            const cat = info.event.extendedProps.category;
            const color = info.event.backgroundColor;
            if (cat && color && !categoryColors[cat]) {
                categoryColors[cat] = color;
                updateLegend();
            }
        },
        dayMaxEvents: 3,
        moreLinkText: function(n) { return '+' + n + ' lainnya'; },
        moreLinkClick: 'popover',
        height: 'auto',
        fixedWeekCount: false,
    });

    calendar.render();

    // View switcher
    document.querySelectorAll('.cal-view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.cal-view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            calendar.changeView(this.dataset.view);
        });
    });

    // Show event modal
    function showEventModal(event) {
        const props = event.extendedProps;

        document.getElementById('eventModalTitle').textContent = event.title;

        // Header gradient with event color
        const eventColor = event.backgroundColor || '#C8A34D';
        document.getElementById('eventModalHeader').style.background =
            `linear-gradient(135deg, ${eventColor}dd, ${eventColor}99)`;

        // Dates
        const startDate = event.start ? formatDate(event.start) : '-';
        const endDate = event.end ? formatDate(new Date(event.end.getTime() - 86400000)) : null;
        document.getElementById('eventModalDate').textContent =
            endDate && endDate !== startDate ? `${startDate} — ${endDate}` : startDate;

        // Location
        document.getElementById('eventModalLocation').textContent = props.location || props.location_name || 'Bali';

        // Category
        document.getElementById('eventModalCategory').textContent = props.category || props.category_name || '-';

        // Quota
        if (props.current_participants != null && props.max_participants != null) {
            const seatsLeft = props.max_participants - props.current_participants;
            document.getElementById('eventModalQuota').textContent =
                `${props.current_participants}/${props.max_participants} peserta (${seatsLeft} kursi tersisa)`;
            document.getElementById('eventModalQuotaWrap').style.display = 'flex';
        } else {
            document.getElementById('eventModalQuotaWrap').style.display = 'none';
        }

        // Price
        if (props.price && props.price > 0) {
            document.getElementById('eventModalPrice').textContent =
                'Rp ' + parseInt(props.price).toLocaleString('id-ID');
            document.getElementById('eventModalPriceWrap').style.display = 'flex';
        } else if (props.price === 0) {
            document.getElementById('eventModalPrice').textContent = 'Gratis';
            document.getElementById('eventModalPriceWrap').style.display = 'flex';
        } else {
            document.getElementById('eventModalPriceWrap').style.display = 'none';
        }

        // WA Button
        const waBtn = document.getElementById('eventModalWaBtn');
        waBtn.onclick = function() {
            const trainingTitle = event.title;
            const trainingDate = startDate;
            const waNumber = '<?= esc($profile['whatsapp'] ?? '6281803867430') ?>';
            const msg = `Halo Admin BKC 👋\n\nSaya ingin mendaftarkan diri pada pelatihan berikut:\n\n📚 *${trainingTitle}*\n📅 Tanggal: ${trainingDate}\n\nMohon informasi lebih lanjut. Terima kasih.`;
            window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`, '_blank', 'noopener');
        };

        // Detail link
        const detailBtn = document.getElementById('eventModalDetailBtn');
        if (event.url) {
            detailBtn.href = event.url;
            detailBtn.style.display = 'flex';
        } else {
            detailBtn.style.display = 'none';
        }

        eventModal.show();
    }

    // Update legend
    function updateLegend() {
        const container = document.getElementById('legendItems');
        if (!container) return;
        container.innerHTML = '';
        Object.entries(categoryColors).forEach(([cat, color]) => {
            const div = document.createElement('div');
            div.className = 'legend-item';
            div.innerHTML = `<div class="legend-dot" style="background:${color};"></div><span>${cat}</span>`;
            container.appendChild(div);
        });

        if (Object.keys(categoryColors).length === 0) {
            container.innerHTML = '<div class="legend-item"><div class="legend-dot" style="background:#C8A34D;"></div><span>Pelatihan</span></div>';
        }
    }

    // Date formatter (Indonesian)
    function formatDate(date) {
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }

    // Initial legend from events
    calEvents.forEach(ev => {
        if (ev.extendedProps && ev.extendedProps.category && ev.backgroundColor) {
            categoryColors[ev.extendedProps.category] = ev.backgroundColor;
        }
    });
    updateLegend();
});
</script>

<?= $this->endSection() ?>
