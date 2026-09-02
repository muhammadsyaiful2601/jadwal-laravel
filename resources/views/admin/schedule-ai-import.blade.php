{{--
    Import Jadwal AI (Gemini 1.5 Flash)
    Dipakai oleh : resources/views/admin/manage-schedule.blade.php
    Variabel     : $rooms, $kelasList, $semesterAktif, $tahunAkademikAktif
--}}

<style>
    /* ===================== Tombol Import AI ===================== */
    .btn-ai-import {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #8E2DE2 0%, #A66CFF 45%, #6BB5FF 100%);
        background-size: 200% 200%;
        color: var(--nb-white);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        padding: 10px 22px;
        font-family: var(--font-display);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-shadow: var(--nb-shadow-sm);
        transition: all 0.15s ease;
        animation: aiGradientShift 4s ease infinite;
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.25);
        white-space: nowrap;
    }

    .btn-ai-import:hover {
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
        color: var(--nb-white);
        filter: brightness(1.08);
    }

    .btn-ai-import:active {
        transform: translate(2px, 2px);
        box-shadow: none;
    }

    .btn-ai-import:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    @keyframes aiGradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .ai-modal-header {
        background: linear-gradient(135deg, #8E2DE2 0%, #A66CFF 55%, #6BB5FF 100%);
    }

    /* ===================== Dropzone Upload ===================== */
    .ai-dropzone {
        border: 3px dashed var(--nb-black);
        border-radius: var(--nb-radius);
        background: var(--nb-offwhite);
        padding: 36px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }

    .ai-dropzone:hover,
    .ai-dropzone.dragover {
        background: #F3EBFF;
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow-sm);
    }

    .ai-dropzone .ai-dropzone-icon {
        font-size: 2.4rem;
        color: #8E2DE2;
        margin-bottom: 10px;
        display: block;
    }

    .ai-dropzone strong {
        font-family: var(--font-display);
        font-size: 0.95rem;
        display: block;
        margin-bottom: 4px;
    }

    .ai-dropzone small {
        color: var(--nb-dark);
        font-weight: 600;
    }

    .ai-file-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        background: var(--nb-white);
        border: 2px solid var(--nb-black);
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        box-shadow: var(--nb-shadow-sm);
    }

    .ai-file-chip .remove-file {
        cursor: pointer;
        color: var(--nb-red);
        font-weight: 900;
    }

    /* ===================== Loading Overlay ===================== */
    .ai-loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(248, 247, 244, 0.96);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: var(--nb-radius);
    }

    .ai-loading-overlay.d-none {
        display: none;
    }

    .ai-loading-box {
        text-align: center;
        padding: 24px;
        max-width: 420px;
    }

    .ai-spinner {
        width: 64px;
        height: 64px;
        margin: 0 auto 18px;
        border: 6px solid var(--nb-black);
        border-top-color: #A66CFF;
        border-right-color: #6BB5FF;
        border-radius: 50%;
        animation: aiSpin 0.9s linear infinite;
    }

    @keyframes aiSpin {
        to { transform: rotate(360deg); }
    }

    .ai-loading-title {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .ai-loading-step {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--nb-dark);
        min-height: 1.4em;
    }

    .ai-progress {
        margin-top: 14px;
        height: 16px;
        border: 2px solid var(--nb-black);
        border-radius: 999px;
        background: var(--nb-white);
        overflow: hidden;
    }

    .ai-progress-bar {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #8E2DE2, #A66CFF, #6BB5FF);
        transition: width 0.25s ease;
    }

    /* ===================== Modal Preview & Validasi ===================== */
    .ai-summary-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 16px;
    }

    .ai-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 2px solid var(--nb-black);
        border-radius: 999px;
        padding: 6px 14px;
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        background: var(--nb-white);
        box-shadow: var(--nb-shadow-sm);
    }

    .ai-chip.chip-total i { color: #8E2DE2; }
    .ai-chip.chip-valid i { color: #1E9E5A; }
    .ai-chip.chip-bentrok i { color: var(--nb-red); }

    .ai-preview-wrap {
        overflow-x: auto;
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        background: var(--nb-white);
    }

    .ai-preview-table {
        width: 100%;
        min-width: 980px;
        border-collapse: collapse;
        font-size: 0.82rem;
    }

    .ai-preview-table thead th {
        background: var(--nb-black);
        color: var(--nb-white);
        font-family: var(--font-display);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 12px;
        white-space: nowrap;
        text-align: left;
    }

    .ai-preview-table tbody td {
        padding: 10px 12px;
        border-bottom: 2px solid var(--nb-gray);
        vertical-align: top;
        font-weight: 600;
    }

    .ai-preview-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Baris VALID = hijau, BARIS BENTROK = merah */
    .ai-row-valid {
        background: #EAFBF0;
        border-left: 6px solid #1E9E5A;
    }

    .ai-row-bentrok {
        background: #FDECEC;
        border-left: 6px solid var(--nb-red);
    }

    .ai-row-editing {
        background: #FFFBEA;
    }

    .ai-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 2px solid var(--nb-black);
        border-radius: 999px;
        padding: 3px 10px;
        font-family: var(--font-display);
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .ai-badge-valid {
        background: #95E1D3;
    }

    .ai-badge-bentrok {
        background: var(--nb-red);
        color: var(--nb-white);
    }

    .ai-error-msg {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        margin-top: 6px;
        color: #C0392B;
        font-size: 0.7rem;
        font-weight: 700;
        line-height: 1.35;
    }

    .ai-error-msg i {
        margin-top: 2px;
        font-size: 0.68rem;
    }

    .ai-mk-title {
        font-weight: 700;
        word-break: break-word;
    }

    /* Inline edit */
    .ai-inline-input {
        width: 100%;
        min-width: 90px;
        padding: 5px 8px;
        border: 2px solid var(--nb-black);
        border-radius: 6px;
        font-family: var(--font-body);
        font-size: 0.78rem;
        font-weight: 600;
        background: var(--nb-white);
        outline: none;
    }

    .ai-inline-input:focus {
        box-shadow: var(--nb-shadow-sm);
    }

    .ai-action-group {
        display: inline-flex;
        gap: 6px;
    }

    .ai-btn-mini {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--nb-black);
        border-radius: 6px;
        background: var(--nb-white);
        color: var(--nb-black);
        cursor: pointer;
        font-size: 0.78rem;
        transition: all 0.15s ease;
        box-shadow: 2px 2px 0 #000;
    }

    .ai-btn-mini:hover {
        transform: translate(-1px, -1px);
        box-shadow: 3px 3px 0 #000;
    }

    .ai-btn-mini.save { background: #95E1D3; }
    .ai-btn-mini.cancel { background: var(--nb-gray); }
    .ai-btn-mini.edit { background: var(--nb-yellow); }
    .ai-btn-mini.delete { background: var(--nb-red); color: var(--nb-white); }

    .ai-btn-mini:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-ai-save-valid {
        background: linear-gradient(135deg, #1E9E5A, #95E1D3);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        color: var(--nb-black);
        padding: 10px 20px;
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: var(--nb-shadow-sm);
        transition: all 0.15s ease;
    }

    .btn-ai-save-valid:hover {
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
    }

    .btn-ai-save-valid:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .ai-empty-row td {
        text-align: center;
        padding: 28px !important;
        color: var(--nb-dark);
        font-weight: 700;
    }
</style>

<!-- ================== Modal Upload File AI ================== -->
<div class="modal fade" id="aiImportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern ai-modal-header d-flex align-items-center justify-content-between">
                <h5 class="modal-title">
                    <i class="fas fa-wand-magic-sparkles me-2"></i> ✨ Import Jadwal AI
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="aiUploadCloseBtn"></button>
            </div>
            <div class="modal-body-modern" style="position:relative;">
                <!-- Loading Overlay -->
                <div id="aiLoadingOverlay" class="ai-loading-overlay d-none">
                    <div class="ai-loading-box">
                        <div class="ai-spinner"></div>
                        <div class="ai-loading-title">AI Sedang Bekerja...</div>
                        <div class="ai-loading-step" id="aiLoadingStep">Mengunggah dokumen...</div>
                        <div class="ai-progress">
                            <div class="ai-progress-bar" id="aiProgressBar"></div>
                        </div>
                    </div>
                </div>

                <p style="font-size:0.85rem;font-weight:600;color:var(--nb-dark);margin-bottom:14px;">
                    Unggah dokumen jadwal kuliah (PDF, Excel, CSV, atau foto/screenshot jadwal).
                    AI akan membaca dokumen, mengekstrak datanya, dan memeriksa bentrok jadwal secara otomatis.
                </p>

                <div id="aiDropzone" class="ai-dropzone">
                    <i class="fas fa-cloud-arrow-up"></i>
                    <strong>Klik atau tarik file ke area ini</strong>
                    <small>Format: .pdf, .xlsx, .csv, .png, .jpg — maksimal 10 MB</small>
                </div>
                <input type="file" id="aiFileInput" accept=".pdf,.xlsx,.csv,.png,.jpg,.jpeg" style="display:none;">
                <div id="aiFileChipWrap"></div>

                <div class="modal-section-title" style="margin-top:16px;">
                    <i class="fas fa-circle-info"></i> Catatan
                </div>
                <ul style="font-size:0.8rem;font-weight:600;color:var(--nb-dark);padding-left:20px;margin:0;">
                    <li>Hasil scan akan ditampilkan pada modal <strong>Preview &amp; Validasi</strong> sebelum disimpan.</li>
                    <li>Baris yang bentrok bisa langsung diedit di tabel sebelum disimpan.</li>
                    <li>Data akan masuk ke semester aktif: <strong>{{ $semesterAktif }} - {{ $tahunAkademikAktif }}</strong>.</li>
                </ul>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn-modal-primary" id="btnStartAiScan">
                    <i class="fas fa-wand-magic-sparkles me-1"></i> Mulai Scan AI
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============ Modal Preview & Validasi ============ -->
<div class="modal fade" id="aiPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern ai-modal-header d-flex align-items-center justify-content-between">
                <h5 class="modal-title">
                    <i class="fas fa-table-list me-2"></i> Preview &amp; Validasi Hasil Scan AI
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <div class="ai-summary-chips">
                    <span class="ai-chip chip-total"><i class="fas fa-list"></i> Total: <span id="aiChipTotal">0</span></span>
                    <span class="ai-chip chip-valid"><i class="fas fa-circle-check"></i> Valid: <span id="aiChipValid">0</span></span>
                    <span class="ai-chip chip-bentrok"><i class="fas fa-triangle-exclamation"></i> Bentrok: <span id="aiChipBentrok">0</span></span>
                </div>

                <div class="ai-preview-wrap">
                    <table class="ai-preview-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Mata Kuliah</th>
                                <th>Ruangan</th>
                                <th>Dosen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="aiPreviewBody"></tbody>
                    </table>
                </div>

                <p style="font-size:0.75rem;font-weight:600;color:var(--nb-dark);margin-top:12px;margin-bottom:0;">
                    <i class="fas fa-pen-to-square me-1"></i>
                    Klik ikon pensil untuk <strong>edit langsung di baris</strong> (jam, ruangan, dosen, dll).
                    Baris berwarna <span style="color:#1E9E5A;">hijau = valid</span>,
                    <span style="color:#C0392B;">merah = bentrok</span>. Hanya baris valid yang akan disimpan.
                </p>

                <datalist id="aiKelasList">
                    @foreach ($kelasList as $kelasItem)
                        <option value="{{ $kelasItem }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <button type="button" class="btn-ai-save-valid" id="btnAiSaveValid" disabled>
                    <i class="fas fa-save me-1"></i> Simpan Data Valid (<span id="aiValidCount">0</span>)
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    /* ===================== Konfigurasi & State ===================== */
    var AI_ROUTES = {
        scan: '{{ url('/admin/manage-schedule/import-ai') }}',
        validate: '{{ url('/admin/manage-schedule/import-ai/validate') }}',
        store: '{{ url('/admin/manage-schedule/import-ai/store') }}'
    };
    var AI_ROOMS = @json($rooms ?? []);
    var AI_DAYS = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];
    var AI_SEMESTER = @json($semesterAktif);
    var AI_TAHUN = @json($tahunAkademikAktif);
    var AI_ALLOWED_EXT = ['pdf', 'xlsx', 'csv', 'png', 'jpg', 'jpeg'];
    var AI_MAX_SIZE = 10 * 1024 * 1024; // 10 MB

    var aiImportState = {
        items: [],
        scanning: false,
        loadingTimer: null
    };

    /* ===================== Helper ===================== */
    function notifyAi(type, message) {
        if (typeof showNotification === 'function') {
            showNotification(type, message);
        } else {
            alert(message);
        }
    }

    function aiEscape(str) {
        return String(str === null || str === undefined ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function setAiProgress(percent, stepText) {
        $('#aiProgressBar').css('width', percent + '%');
        if (stepText) {
            $('#aiLoadingStep').text(stepText);
        }
    }

    function startAiLoadingMessages() {
        var steps = [
            'AI membaca dokumen...',
            'Mengekstrak data jadwal...',
            'Menyusun hasil ekstraksi...',
            'Memeriksa bentrok jadwal...'
        ];
        var i = 0;
        aiImportState.loadingTimer = setInterval(function () {
            i = (i + 1) % steps.length;
            $('#aiLoadingStep').text(steps[i]);
        }, 3000);
    }

    function stopAiLoadingMessages() {
        if (aiImportState.loadingTimer) {
            clearInterval(aiImportState.loadingTimer);
            aiImportState.loadingTimer = null;
        }
    }

    function setAiLoading(on) {
        aiImportState.scanning = on;
        $('#aiLoadingOverlay').toggleClass('d-none', !on);
        $('#btnStartAiScan').prop('disabled', on).html(
            on
                ? '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...'
                : '<i class="fas fa-wand-magic-sparkles me-1"></i> Mulai Scan AI'
        );
        if (!on) {
            stopAiLoadingMessages();
            setAiProgress(0);
        }
    }

    /* ===================== Dropzone & File Input ===================== */
    function aiShowFileChip(file) {
        var sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        $('#aiFileChipWrap').html(
            '<span class="ai-file-chip"><i class="fas fa-file-lines" style="color:#8E2DE2;"></i> ' +
            aiEscape(file.name) + ' (' + sizeMb + ' MB)' +
            ' <span class="remove-file" title="Hapus file" onclick="aiClearFile()">&times;</span></span>'
        );
    }

    function aiClearFile() {
        $('#aiFileInput').val('');
        $('#aiFileChipWrap').empty();
    }

    function aiAcceptFile(file) {
        if (!file) {
            return;
        }
        var ext = (file.name.split('.').pop() || '').toLowerCase();
        if (AI_ALLOWED_EXT.indexOf(ext) === -1) {
            notifyAi('error', 'Format file tidak didukung. Gunakan: ' + AI_ALLOWED_EXT.join(', ') + '.');
            return;
        }
        if (file.size > AI_MAX_SIZE) {
            notifyAi('error', 'Ukuran file maksimal 10 MB.');
            return;
        }
        // Set ke input agar nilai tetap tersimpan
        try {
            var dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('aiFileInput').files = dt.files;
        } catch (e) {
            // Fallback browser lama: biarkan input asli
        }
        aiShowFileChip(file);
    }

    $(function () {
        var dropzone = document.getElementById('aiDropzone');
        var fileInput = document.getElementById('aiFileInput');

        $(dropzone).on('click', function () {
            if (!aiImportState.scanning) {
                fileInput.click();
            }
        });

        $(fileInput).on('change', function () {
            if (this.files && this.files[0]) {
                aiAcceptFile(this.files[0]);
            }
        });

        ['dragenter', 'dragover'].forEach(function (evt) {
            dropzone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(function (evt) {
            dropzone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', function (e) {
            if (aiImportState.scanning) {
                return;
            }
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]) {
                aiAcceptFile(e.dataTransfer.files[0]);
            }
        });

        // Reset input file ketika modal upload ditutup
        $('#aiImportModal').on('hidden.bs.modal', function () {
            if (!aiImportState.scanning) {
                aiClearFile();
            }
        });

        // Bersihkan state ketika modal preview ditutup
        $('#aiPreviewModal').on('hidden.bs.modal', function () {
            aiImportState.items = [];
            renderAiPreview();
        });

        $('#btnStartAiScan').on('click', startAiScan);
        $('#btnAiSaveValid').on('click', saveAiValidRows);
    });

    /* ============ Scan AI (kirim file ke backend -> Gemini) ============ */
    function startAiScan() {
        if (aiImportState.scanning) {
            return;
        }

        var fileInput = document.getElementById('aiFileInput');
        var file = fileInput.files && fileInput.files[0];

        if (!file) {
            notifyAi('error', 'Pilih file dokumen terlebih dahulu.');
            return;
        }

        var ext = (file.name.split('.').pop() || '').toLowerCase();
        if (AI_ALLOWED_EXT.indexOf(ext) === -1) {
            notifyAi('error', 'Format file tidak didukung. Gunakan: ' + AI_ALLOWED_EXT.join(', ') + '.');
            return;
        }

        if (file.size > AI_MAX_SIZE) {
            notifyAi('error', 'Ukuran file maksimal 10 MB.');
            return;
        }

        setAiLoading(true);
        setAiProgress(5, 'Mengunggah dokumen...');
        startAiLoadingMessages();

        var formData = new FormData();
        formData.append('file', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: AI_ROUTES.scan,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        var pct = Math.max(5, Math.round((e.loaded / e.total) * 40)); // 5-40% saat upload
                        setAiProgress(pct, 'Mengunggah dokumen... ' + Math.round((e.loaded / e.total) * 100) + '%');
                        if (e.loaded >= e.total) {
                            setAiProgress(45, 'AI membaca dokumen...');
                        }
                    }
                });
                return xhr;
            },
            success: function (response) {
                setAiProgress(100, 'Selesai!');
                if (response.success) {
                    aiImportState.items = response.data || [];
                    renderAiPreview();
                    $('#aiImportModal').modal('hide');
                    setTimeout(function () {
                        new bootstrap.Modal(document.getElementById('aiPreviewModal')).show();
                    }, 400);
                } else {
                    notifyAi('error', response.message || 'Gagal memproses file.');
                }
            },
            error: function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message
                    : 'Terjadi kesalahan saat menghubungi AI. Periksa koneksi / GEMINI_API_KEY.';
                notifyAi('error', msg);
            },
            complete: function () {
                setAiLoading(false);
            }
        });
    }

    /* ===================== Render Tabel Preview ===================== */
    function aiErrorLists(pesan) {
        // Pisahkan pesan error ke bawah kolom Ruangan / Dosen
        var lists = { ruangan: [], dosen: [] };
        if (!pesan) {
            return lists;
        }
        String(pesan).split(' | ').forEach(function (m) {
            var trimmed = m.trim();
            if (/^Dosen/i.test(trimmed)) {
                lists.dosen.push(trimmed);
            } else {
                lists.ruangan.push(trimmed);
            }
        });
        return lists;
    }

    function aiErrorHtml(messages) {
        if (!messages || messages.length === 0) {
            return '';
        }
        var html = '';
        messages.forEach(function (m) {
            html += '<div class="ai-error-msg"><i class="fas fa-triangle-exclamation"></i><span>' +
                aiEscape(m) + '</span></div>';
        });
        return html;
    }

    function aiStatusBadge(status) {
        if (status === 'valid') {
            return '<span class="ai-badge ai-badge-valid"><i class="fas fa-check"></i> Valid</span>';
        }
        return '<span class="ai-badge ai-badge-bentrok"><i class="fas fa-triangle-exclamation"></i> Bentrok</span>';
    }

    function updateAiSummary() {
        var total = aiImportState.items.length;
        var valid = 0;
        var bentrok = 0;
        aiImportState.items.forEach(function (item) {
            if (item.status === 'valid') {
                valid++;
            } else {
                bentrok++;
            }
        });
        $('#aiChipTotal').text(total);
        $('#aiChipValid').text(valid);
        $('#aiChipBentrok').text(bentrok);
        $('#aiValidCount').text(valid);
        $('#btnAiSaveValid').prop('disabled', valid === 0);
    }

    function renderAiPreview() {
        var tbody = $('#aiPreviewBody');
        tbody.empty();

        if (aiImportState.items.length === 0) {
            tbody.html('<tr class="ai-empty-row"><td colspan="9">' +
                '<i class="fas fa-inbox" style="font-size:1.6rem;display:block;margin-bottom:8px;"></i>' +
                'Belum ada data. Lakukan scan dokumen terlebih dahulu.</td></tr>');
            updateAiSummary();
            return;
        }

        aiImportState.items.forEach(function (item, index) {
            var rowClass = item.status === 'valid' ? 'ai-row-valid' : 'ai-row-bentrok';
            var errors = aiErrorLists(item.pesan_error);

            var html =
                '<tr class="' + rowClass + '" data-index="' + index + '">' +
                '<td>' + aiStatusBadge(item.status) + '</td>' +
                '<td>' + (aiEscape(item.kelas) || '<em style="color:#C0392B;">(kosong)</em>') + '</td>' +
                '<td>' + aiEscape(item.hari) + '</td>' +
                '<td>' + aiEscape(item.jam_mulai) + '</td>' +
                '<td>' + aiEscape(item.jam_selesai) + '</td>' +
                '<td><span class="ai-mk-title">' + aiEscape(item.matakuliah) + '</span></td>' +
                '<td>' + aiEscape(item.ruangan) + aiErrorHtml(errors.ruangan) + '</td>' +
                '<td>' + aiEscape(item.dosen) + aiErrorHtml(errors.dosen) + '</td>' +
                '<td>' +
                '<div class="ai-action-group">' +
                '<button type="button" class="ai-btn-mini edit" title="Edit baris" onclick="aiEditRow(' + index + ')">' +
                '<i class="fas fa-pen"></i></button>' +
                '<button type="button" class="ai-btn-mini delete" title="Hapus baris" onclick="aiDeleteRow(' + index + ')">' +
                '<i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';

            tbody.append(html);
        });

        updateAiSummary();
    }

    /* ===================== Inline Edit ===================== */
    function aiBuildHariSelect(current) {
        var options = AI_DAYS.slice();
        if (current && options.indexOf(current) === -1) {
            options.unshift(current);
        }
        var html = '<select class="ai-inline-input" data-field="hari">';
        options.forEach(function (day) {
            html += '<option value="' + aiEscape(day) + '"' + (day === current ? ' selected' : '') + '>' +
                aiEscape(day) + '</option>';
        });
        html += '</select>';
        return html;
    }

    function aiBuildRuanganSelect(current) {
        var options = AI_ROOMS.slice();
        if (current && options.indexOf(current) === -1) {
            options.unshift(current);
        }
        var html = '<select class="ai-inline-input" data-field="ruangan">';
        if (!current) {
            html += '<option value="">Pilih Ruangan</option>';
        }
        options.forEach(function (room) {
            html += '<option value="' + aiEscape(room) + '"' + (room === current ? ' selected' : '') + '>' +
                aiEscape(room) + '</option>';
        });
        html += '</select>';
        return html;
    }

    function aiEditRow(index) {
        var item = aiImportState.items[index];
        if (!item) {
            return;
        }

        var row = $('#aiPreviewBody tr[data-index="' + index + '"]');
        if (row.hasClass('ai-row-editing')) {
            return;
        }
        row.addClass('ai-row-editing');

        row.find('td').eq(0).html('<span class="ai-badge" style="background:#FFE66D;"><i class="fas fa-pen"></i> Edit</span>');
        row.find('td').eq(1).html('<input type="text" class="ai-inline-input" data-field="kelas" list="aiKelasList" value="' + aiEscape(item.kelas) + '" placeholder="Contoh: TI-1A">');
        row.find('td').eq(2).html(aiBuildHariSelect(item.hari));
        row.find('td').eq(3).html('<input type="time" class="ai-inline-input" data-field="jam_mulai" value="' + aiEscape(item.jam_mulai) + '">');
        row.find('td').eq(4).html('<input type="time" class="ai-inline-input" data-field="jam_selesai" value="' + aiEscape(item.jam_selesai) + '">');
        row.find('td').eq(5).html('<input type="text" class="ai-inline-input" data-field="matakuliah" value="' + aiEscape(item.matakuliah) + '">');
        row.find('td').eq(6).html(aiBuildRuanganSelect(item.ruangan));
        row.find('td').eq(7).html('<input type="text" class="ai-inline-input" data-field="dosen" value="' + aiEscape(item.dosen) + '">');
        row.find('td').eq(8).html(
            '<div class="ai-action-group">' +
            '<button type="button" class="ai-btn-mini save" title="Simpan perubahan" onclick="aiSaveRow(' + index + ')">' +
            '<i class="fas fa-check"></i></button>' +
            '<button type="button" class="ai-btn-mini cancel" title="Batal" onclick="aiCancelEdit()">' +
            '<i class="fas fa-times"></i></button>' +
            '</div>'
        );
    }

    function aiCancelEdit() {
        renderAiPreview();
    }

    /* ============ Simpan Edit Inline (validasi ulang ke backend) ============ */
    function aiSaveRow(index) {
        var row = $('#aiPreviewBody tr[data-index="' + index + '"]');
        var item = aiImportState.items[index];
        if (!row.length || !item) {
            return;
        }

        var updated = $.extend({}, item, {
            kelas: row.find('[data-field="kelas"]').val().trim(),
            hari: row.find('[data-field="hari"]').val(),
            jam_mulai: row.find('[data-field="jam_mulai"]').val(),
            jam_selesai: row.find('[data-field="jam_selesai"]').val(),
            matakuliah: row.find('[data-field="matakuliah"]').val().trim(),
            ruangan: row.find('[data-field="ruangan"]').val(),
            dosen: row.find('[data-field="dosen"]').val().trim()
        });

        if (!updated.jam_mulai || !updated.jam_selesai) {
            notifyAi('error', 'Jam mulai dan jam selesai wajib diisi.');
            return;
        }
        if (updated.jam_selesai <= updated.jam_mulai) {
            notifyAi('error', 'Jam selesai harus lebih besar dari jam mulai.');
            return;
        }

        row.find('.ai-btn-mini').prop('disabled', true);

        $.ajax({
            url: AI_ROUTES.validate,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                item: updated
            },
            success: function (response) {
                if (response.success) {
                    updated.hari = response.hari;
                    updated.jam_mulai = response.jam_mulai;
                    updated.jam_selesai = response.jam_selesai;
                    updated.jam_ke = response.jam_ke;
                    updated.status = response.status;
                    updated.pesan_error = response.pesan_error;
                    aiImportState.items[index] = updated;
                    renderAiPreview();
                    if (response.status === 'valid') {
                        notifyAi('success', 'Baris diperbarui & tidak bentrok.');
                    }
                } else {
                    notifyAi('error', response.message || 'Gagal memvalidasi baris.');
                    row.find('.ai-btn-mini').prop('disabled', false);
                }
            },
            error: function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message
                    : 'Terjadi kesalahan saat memvalidasi baris.';
                notifyAi('error', msg);
                row.find('.ai-btn-mini').prop('disabled', false);
            }
        });
    }

    function aiDeleteRow(index) {
        var item = aiImportState.items[index];
        if (!item) {
            return;
        }
        if (!confirm('Hapus baris "' + (item.matakuliah || '(tanpa nama)') + '" dari hasil import?')) {
            return;
        }
        aiImportState.items.splice(index, 1);
        renderAiPreview();
    }

    /* ============ Simpan Data Valid ke Database ============ */
    function saveAiValidRows() {
        var validRows = aiImportState.items.filter(function (item) {
            return item.status === 'valid';
        });

        if (validRows.length === 0) {
            notifyAi('error', 'Tidak ada baris valid untuk disimpan. Edit baris yang bentrok terlebih dahulu.');
            return;
        }

        var btn = $('#btnAiSaveValid');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        $.ajax({
            url: AI_ROUTES.store,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                schedules: validRows
            },
            success: function (response) {
                if (response.success) {
                    $('#aiPreviewModal').modal('hide');
                    notifyAi('success', response.message || 'Data berhasil disimpan!');
                    setTimeout(function () {
                        window.location.href = '{{ url('/admin/manage-schedule') }}';
                    }, 1200);
                } else {
                    notifyAi('error', response.message || 'Gagal menyimpan data.');
                    updateAiSummary();
                }
            },
            error: function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message
                    : 'Terjadi kesalahan saat menyimpan data.';
                notifyAi('error', msg);
                updateAiSummary();
            }
        });
    }
</script>
</style>
