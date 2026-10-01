<?= $this->extend('Modules\Website\Views\layout\main') ?>

<?= $this->section('meta') ?>
<title><?= esc($title) ?> | <?= esc($profile['company_name'] ?? 'BKC') ?></title>
<meta name="description" content="Temukan jawaban atas pertanyaan umum seputar program pelatihan, pendaftaran, sertifikat, dan layanan <?= esc($profile['company_name'] ?? 'BKC') ?>.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .faq-hero {
        background: linear-gradient(135deg, #1E4FA3 0%, #0d2d6b 100%);
        padding: 120px 0 60px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .faq-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(ellipse at center, rgba(200,163,77,0.15) 0%, transparent 60%);
        animation: rotateGlow 20s linear infinite;
    }
    @keyframes rotateGlow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .faq-hero h1 { font-size: 2.8rem; font-weight: 800; position: relative; }
    .faq-hero p { font-size: 1.1rem; opacity: 0.85; position: relative; }

    .faq-search-wrap {
        background: white;
        border-radius: 50px;
        padding: 8px 8px 8px 24px;
        display: flex;
        align-items: center;
        max-width: 560px;
        margin: 24px auto 0;
        box-shadow: 0 8px 32px rgba(30,79,163,0.2);
        position: relative;
    }
    .faq-search-wrap input {
        border: none;
        outline: none;
        flex: 1;
        font-size: 0.95rem;
        background: transparent;
    }
    .faq-search-wrap button {
        background: linear-gradient(135deg, #C8A34D, #a8842d);
        color: white;
        border: none;
        border-radius: 40px;
        padding: 10px 24px;
        font-weight: 600;
        cursor: pointer;
    }

    .faq-category-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 32px;
    }
    .faq-tab-btn {
        padding: 8px 20px;
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        background: white;
        color: #64748b;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.25s;
        font-size: 0.9rem;
    }
    .faq-tab-btn.active, .faq-tab-btn:hover {
        border-color: #C8A34D;
        background: #C8A34D;
        color: white;
    }

    .faq-section { margin-bottom: 48px; }
    .faq-category-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1E4FA3;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .faq-category-title::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 20px;
        background: #C8A34D;
        border-radius: 2px;
    }

    .accordion-item {
        border: 1px solid #e2e8f0;
        border-radius: 12px !important;
        margin-bottom: 10px;
        overflow: hidden;
        transition: box-shadow 0.2s;
    }
    .accordion-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .accordion-button {
        font-weight: 600;
        color: #1a202c;
        background: white;
        font-size: 0.97rem;
        padding: 18px 20px;
        border-radius: 12px !important;
    }
    .accordion-button:not(.collapsed) {
        color: #1E4FA3;
        background: linear-gradient(135deg, #f0f4ff, #fff);
        box-shadow: none;
    }
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231E4FA3'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    .accordion-body {
        color: #4a5568;
        line-height: 1.8;
        padding: 0 20px 20px;
        font-size: 0.95rem;
    }

    .faq-cta {
        background: linear-gradient(135deg, #1E4FA3 0%, #0d2d6b 100%);
        border-radius: 20px;
        padding: 48px;
        text-align: center;
        color: white;
        margin-top: 48px;
    }
    .faq-cta h3 { font-size: 1.8rem; font-weight: 700; margin-bottom: 12px; }
    .faq-cta p { opacity: 0.85; margin-bottom: 24px; }
    .btn-wa-cta {
        background: #25D366;
        color: white;
        padding: 14px 32px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        font-size: 1rem;
    }
    .btn-wa-cta:hover { background: #128C7E; color: white; transform: translateY(-2px); }

    .no-result-found { display: none; }
    .no-result-found.active { display: block; }
    .faq-item.hidden { display: none; }
</style>

<!-- Hero -->
<section class="faq-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span style="background:rgba(200,163,77,0.2);color:#C8A34D;padding:6px 18px;border-radius:50px;font-size:0.85rem;font-weight:600;letter-spacing:1px;">PUSAT BANTUAN</span>
            <h1 class="mt-3">Pertanyaan yang Sering<br>Diajukan <span style="color:#C8A34D">(FAQ)</span></h1>
            <p>Temukan jawaban cepat untuk pertanyaan umum Anda seputar program pelatihan dan layanan kami.</p>
            <div class="faq-search-wrap">
                <i class="fas fa-search" style="color:#94a3b8;margin-right:8px;"></i>
                <input type="text" id="faqSearch" placeholder="Cari pertanyaan...">
                <button type="button">Cari</button>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section style="padding: 80px 0; background: #f8fafc;">
    <div class="container">
        <!-- Category Tabs -->
        <?php if (count($grouped) > 1): ?>
        <div class="faq-category-tabs" data-aos="fade-up">
            <button class="faq-tab-btn active" data-category="all">Semua</button>
            <?php foreach (array_keys($grouped) as $cat): ?>
            <button class="faq-tab-btn" data-category="<?= esc($cat) ?>"><?= esc($cat) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <?php if (empty($faqs)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-4x" style="color:#cbd5e1;"></i>
                    <p class="mt-3 text-muted">Belum ada FAQ tersedia.</p>
                </div>
                <?php else: ?>

                <?php foreach ($grouped as $category => $items): ?>
                <div class="faq-section" data-category-group="<?= esc($category) ?>" data-aos="fade-up">
                    <?php if (count($grouped) > 1): ?>
                    <div class="faq-category-title"><?= esc($category) ?></div>
                    <?php endif; ?>

                    <div class="accordion" id="faqAccordion_<?= preg_replace('/[^a-z0-9]/i', '', $category) ?>">
                        <?php foreach ($items as $i => $faq): ?>
                        <div class="accordion-item faq-item" data-question="<?= esc(strtolower($faq['question'])) ?>" data-category="<?= esc($category) ?>">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq_<?= $faq['id'] ?>"
                                    aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                                    <i class="fas fa-circle-question me-2" style="color:#C8A34D;font-size:0.85em;"></i>
                                    <?= esc($faq['question']) ?>
                                </button>
                            </h2>
                            <div id="faq_<?= $faq['id'] ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>">
                                <div class="accordion-body">
                                    <?= $faq['answer'] ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="no-result-found text-center py-5" id="noResult">
                    <i class="fas fa-search fa-3x" style="color:#cbd5e1;"></i>
                    <p class="mt-3 text-muted">Tidak ada pertanyaan yang cocok dengan pencarian Anda.</p>
                </div>

                <?php endif; ?>

                <!-- CTA -->
                <div class="faq-cta" data-aos="fade-up">
                    <h3>Masih Ada Pertanyaan?</h3>
                    <p>Jangan ragu untuk menghubungi tim kami. Kami siap membantu Anda di jam kerja.</p>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['whatsapp'] ?? '6281803867430') ?>"
                       class="btn-wa-cta" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp fa-lg"></i>
                        Chat dengan Kami di WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    // Category filter
    document.querySelectorAll('.faq-tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.faq-tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.category;
            document.querySelectorAll('.faq-section').forEach(section => {
                if (cat === 'all' || section.dataset.categoryGroup === cat) {
                    section.style.display = '';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });

    // Search
    const searchInput = document.getElementById('faqSearch');
    const noResult = document.getElementById('noResult');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            let found = 0;
            document.querySelectorAll('.faq-item').forEach(item => {
                const question = item.dataset.question || '';
                const answer = item.querySelector('.accordion-body')?.textContent?.toLowerCase() || '';
                if (!q || question.includes(q) || answer.includes(q)) {
                    item.classList.remove('hidden');
                    found++;
                } else {
                    item.classList.add('hidden');
                }
            });
            document.querySelectorAll('.faq-section').forEach(section => {
                const visible = section.querySelectorAll('.faq-item:not(.hidden)').length;
                section.style.display = visible > 0 ? '' : 'none';
            });
            noResult.classList.toggle('active', found === 0 && q.length > 0);
        });
    }
})();
</script>

<?= $this->endSection() ?>
