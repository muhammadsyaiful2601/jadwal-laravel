<style>
    /* Modern Modal Styles */
    .modal-content-modern {
        border-radius: var(--nb-radius);
        border: var(--nb-border-thick);
        box-shadow: var(--nb-shadow-lg);
        background: var(--nb-white);
    }

    .modal-header-modern {
        padding: 20px 24px;
        border-bottom: var(--nb-border);
        background: var(--nb-purple);
        color: var(--nb-white);
    }

    .modal-header-modern .modal-title {
        font-family: var(--font-display);
        font-weight: 700;
        color: var(--nb-white);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 1rem;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header-modern .btn-close {
        filter: invert(1);
        opacity: 0.8;
        transition: all 0.15s ease;
    }

    .modal-header-modern .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body-modern {
        padding: 24px;
        max-height: 65vh;
        overflow-y: auto;
    }

    .modal-footer-modern {
        padding: 16px 24px;
        border-top: var(--nb-border);
        background: var(--nb-offwhite);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    .form-label-custom {
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--nb-black);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-custom {
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        padding: 12px 16px;
        font-family: var(--font-body);
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--nb-black);
        background: var(--nb-white);
        outline: none;
        transition: all 0.2s ease;
        width: 100%;
        box-shadow: var(--nb-shadow-sm);
    }

    .form-control-custom:focus {
        border-color: var(--nb-black);
        box-shadow: var(--nb-shadow);
        transform: translate(-2px, -2px);
    }

    .form-control-custom::placeholder {
        color: var(--nb-dark);
        opacity: 0.5;
    }

    .form-select-custom {
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        padding: 10px 14px;
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--nb-black);
        background: var(--nb-white);
        outline: none;
        transition: all 0.15s ease;
        width: 100%;
        box-shadow: var(--nb-shadow-sm);
        cursor: pointer;
    }

    .form-select-custom:focus {
        border-color: var(--nb-black);
        box-shadow: var(--nb-shadow);
        transform: translate(-2px, -2px);
    }

    .form-hint {
        display: block;
        margin-top: 6px;
        font-size: 0.8rem;
        color: var(--nb-dark);
        font-weight: 600;
    }

    .modal-section-title {
        font-family: var(--font-display);
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--nb-white);
        background: var(--nb-dark);
        padding: 10px 16px;
        border-radius: var(--nb-radius-sm);
        margin-bottom: 18px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 2px solid var(--nb-black);
        box-shadow: var(--nb-shadow-sm);
    }

    .modal-section-title i {
        font-size: 0.85rem;
        color: var(--nb-yellow);
    }

    .form-group-modal {
        margin-bottom: 18px;
    }

    .form-group-modal:last-child {
        margin-bottom: 0;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper .input-icon-left {
        position: absolute;
        left: 12px;
        top: 38px;
        background: var(--nb-yellow);
        border: 2px solid var(--nb-black);
        border-radius: var(--nb-radius-sm);
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: var(--nb-black);
        z-index: 2;
        box-shadow: var(--nb-shadow-sm);
    }

    .input-icon-wrapper .form-control-custom,
    .input-icon-wrapper .form-select-custom {
        padding-left: 48px;
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .form-row-enhanced {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 20px;
    }

    .form-row-enhanced.three-cols {
        grid-template-columns: repeat(3, 1fr);
    }

    .form-divider {
        height: 3px;
        background: repeating-linear-gradient(45deg,
                var(--nb-gray),
                var(--nb-gray) 4px,
                var(--nb-offwhite) 4px,
                var(--nb-offwhite) 8px);
        border-radius: 2px;
        margin: 24px 0;
        border: none;
        box-shadow: var(--nb-shadow-sm);
    }

    .readonly-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--nb-green);
        color: var(--nb-black);
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: var(--nb-radius-sm);
        border: 2px solid var(--nb-black);
        box-shadow: var(--nb-shadow-sm);
        margin-top: 8px;
    }

    .readonly-badge i {
        font-size: 0.65rem;
    }

    .btn-modal-primary {
        padding: 12px 28px;
        background: var(--nb-purple);
        color: var(--nb-white);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        font-family: var(--font-display);
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--nb-shadow-sm);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-modal-primary:hover {
        background: var(--nb-pink);
        color: var(--nb-black);
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
    }

    .btn-modal-primary:active {
        transform: translate(2px, 2px);
        box-shadow: none;
    }

    .btn-modal-secondary {
        padding: 12px 28px;
        background: var(--nb-white);
        color: var(--nb-black);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        font-family: var(--font-display);
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--nb-shadow-sm);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-modal-secondary:hover {
        background: var(--nb-gray);
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
    }

    .btn-modal-secondary:active {
        transform: translate(2px, 2px);
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .form-row-enhanced {
            grid-template-columns: 1fr;
        }

        .form-row-enhanced.three-cols {
            grid-template-columns: 1fr;
        }

        .modal-footer-modern {
            flex-direction: column-reverse;
        }

        .modal-footer-modern button {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <form method="POST" action="{{ url('/admin/manage-schedule/store') }}" id="addScheduleForm">
                @csrf
                <div class="modal-header-modern d-flex align-items-center justify-content-between">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i> Tambah Jadwal Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern">
                    <div class="modal-section-title">
                        <i class="fas fa-info-circle"></i> Informasi Kelas
                    </div>
                    <div class="form-row-enhanced">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Kelas</label>
                            <span class="input-icon-left">
                                <i class="fas fa-users"></i>
                            </span>
                            <input type="text" name="kelas" class="form-control-custom" required
                                placeholder="Contoh: TI-1A">
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Hari</label>
                            <span class="input-icon-left">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <select name="hari" class="form-select-custom" required>
                                <option value="">Pilih Hari</option>
                                <option value="SENIN">SENIN</option>
                                <option value="SELASA">SELASA</option>
                                <option value="RABU">RABU</option>
                                <option value="KAMIS">KAMIS</option>
                                <option value="JUMAT">JUMAT</option>
                            </select>
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="modal-section-title">
                        <i class="fas fa-clock"></i> Waktu Kuliah
                    </div>
                    <div class="form-row-enhanced three-cols">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Jam Ke</label>
                            <span class="input-icon-left">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="number" name="jam_ke" class="form-control-custom" min="1"
                                max="10" required placeholder="1-10">
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Waktu Mulai</label>
                            <span class="input-icon-left">
                                <i class="fas fa-play"></i>
                            </span>
                            <input type="time" name="waktu_mulai" class="form-control-custom" required>
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Waktu Selesai</label>
                            <span class="input-icon-left">
                                <i class="fas fa-stop"></i>
                            </span>
                            <input type="time" name="waktu_selesai" class="form-control-custom" required>
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="modal-section-title">
                        <i class="fas fa-book"></i> Mata Kuliah & Dosen
                    </div>
                    <div class="form-row-enhanced">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Mata Kuliah</label>
                            <span class="input-icon-left">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <input type="text" name="mata_kuliah" class="form-control-custom" required
                                placeholder="Nama mata kuliah">
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Dosen</label>
                            <span class="input-icon-left">
                                <i class="fas fa-user-tie"></i>
                            </span>
                            <input type="text" name="dosen" class="form-control-custom" required
                                placeholder="Nama dosen">
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="modal-section-title">
                        <i class="fas fa-map-marker-alt"></i> Ruangan & Semester
                    </div>
                    <div class="form-row-enhanced three-cols">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Ruang</label>
                            <span class="input-icon-left">
                                <i class="fas fa-door-open"></i>
                            </span>
                            <select name="ruang" class="form-select-custom" required>
                                <option value="">Pilih Ruang</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room }}">{{ $room }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label-custom">Semester</label>
                            <input type="text" name="semester" class="form-control-custom"
                                value="{{ $semesterAktif }}" readonly>
                            <span class="readonly-badge">
                                <i class="fas fa-lock"></i> Otomatis
                            </span>
                        </div>
                        <div>
                            <label class="form-label-custom">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control-custom"
                                value="{{ $tahunAkademikAktif }}" readonly>
                            <span class="readonly-badge">
                                <i class="fas fa-lock"></i> Otomatis
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal-primary" id="btnSaveSchedule">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <form method="POST" action="" id="editScheduleForm">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header-modern d-flex align-items-center justify-content-between">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> Edit Jadwal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern">
                    <div class="modal-section-title">
                        <i class="fas fa-info-circle"></i> Informasi Kelas
                    </div>
                    <div class="form-row-enhanced">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Kelas</label>
                            <span class="input-icon-left">
                                <i class="fas fa-users"></i>
                            </span>
                            <input type="text" name="kelas" id="edit_kelas" class="form-control-custom"
                                required placeholder="Contoh: TI-1A">
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Hari</label>
                            <span class="input-icon-left">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <select name="hari" id="edit_hari" class="form-select-custom" required>
                                <option value="">Pilih Hari</option>
                                <option value="SENIN">SENIN</option>
                                <option value="SELASA">SELASA</option>
                                <option value="RABU">RABU</option>
                                <option value="KAMIS">KAMIS</option>
                                <option value="JUMAT">JUMAT</option>
                            </select>
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="modal-section-title">
                        <i class="fas fa-clock"></i> Waktu Kuliah
                    </div>
                    <div class="form-row-enhanced three-cols">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Jam Ke</label>
                            <span class="input-icon-left">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="number" name="jam_ke" id="edit_jam_ke" class="form-control-custom"
                                min="1" max="10" required placeholder="1-10">
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Waktu Mulai</label>
                            <span class="input-icon-left">
                                <i class="fas fa-play"></i>
                            </span>
                            <input type="time" name="waktu_mulai" id="edit_waktu_mulai"
                                class="form-control-custom" required>
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Waktu Selesai</label>
                            <span class="input-icon-left">
                                <i class="fas fa-stop"></i>
                            </span>
                            <input type="time" name="waktu_selesai" id="edit_waktu_selesai"
                                class="form-control-custom" required>
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="modal-section-title">
                        <i class="fas fa-book"></i> Mata Kuliah & Dosen
                    </div>
                    <div class="form-row-enhanced">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Mata Kuliah</label>
                            <span class="input-icon-left">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <input type="text" name="mata_kuliah" id="edit_mata_kuliah"
                                class="form-control-custom" required placeholder="Nama mata kuliah">
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Dosen</label>
                            <span class="input-icon-left">
                                <i class="fas fa-user-tie"></i>
                            </span>
                            <input type="text" name="dosen" id="edit_dosen" class="form-control-custom"
                                required placeholder="Nama dosen">
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="modal-section-title">
                        <i class="fas fa-map-marker-alt"></i> Ruangan & Semester
                    </div>
                    <div class="form-row-enhanced three-cols">
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Ruang</label>
                            <span class="input-icon-left">
                                <i class="fas fa-door-open"></i>
                            </span>
                            <select name="ruang" id="edit_ruang" class="form-select-custom" required>
                                <option value="">Pilih Ruang</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room }}">{{ $room }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label-custom">Semester</label>
                            <select name="semester" id="edit_semester" class="form-select-custom" required>
                                <option value="GANJIL">GANJIL</option>
                                <option value="GENAP">GENAP</option>
                            </select>
                        </div>
                        <div class="input-icon-wrapper">
                            <label class="form-label-custom">Tahun Akademik</label>
                            <span class="input-icon-left">
                                <i class="fas fa-graduation-cap"></i>
                            </span>
                            <input type="text" name="tahun_akademik" id="edit_tahun_akademik"
                                class="form-control-custom" placeholder="Contoh: 2024/2025" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal-primary" id="btnUpdateSchedule">
                        <i class="fas fa-save me-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showNotification(type, message) {
        const container = document.getElementById('notification-container');
        const alertClass = type === 'success' ? 'alert-flash success' : 'alert-flash error';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        container.innerHTML = '<div class="' + alertClass + '"><i class="fas ' + icon + '"></i> ' + message + '</div>';
        setTimeout(function() {
            container.style.transition = 'opacity 0.5s ease';
            container.style.opacity = '0';
            setTimeout(() => {
                container.style.display = 'none';
            }, 500);
        }, 5000);
    }

    function editSchedule(data) {
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_kelas').value = data.kelas;
        document.getElementById('edit_hari').value = data.hari;
        document.getElementById('edit_jam_ke').value = data.jam_ke;
        document.getElementById('edit_mata_kuliah').value = data.mata_kuliah;
        document.getElementById('edit_dosen').value = data.dosen;
        document.getElementById('edit_semester').value = data.semester;
        document.getElementById('edit_tahun_akademik').value = data.tahun_akademik;
        if (data.waktu) {
            var waktuParts = data.waktu.split(' - ');
            if (waktuParts.length === 2) {
                document.getElementById('edit_waktu_mulai').value = waktuParts[0].trim();
                document.getElementById('edit_waktu_selesai').value = waktuParts[1].trim();
            }
        }
        document.getElementById('edit_ruang').value = data.ruang;
        document.getElementById('editScheduleForm').action = '{{ url('/admin/manage-schedule/update') }}/' + data.id;
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    $(document).ready(function() {
        $('#addScheduleForm').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btnSaveSchedule');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        $('#addModal').modal('hide');
                        $('#addScheduleForm')[0].reset();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function() {
                    showNotification('error', 'Terjadi kesalahan.');
                },
                complete: function() {
                    btn.prop('disabled', false).html(
                        '<i class="fas fa-save me-1"></i> Simpan');
                }
            });
        });

        var bulkIndex = 1;
        $('#btnAddMoreSchedule').click(function(e) {
            e.preventDefault();
            var container = $('#bulkSchedulesContainer');
            var template = $('.bulk-schedule-item').first().clone();
            template.attr('data-index', bulkIndex);
            template.find('.item-number').text(bulkIndex + 1);
            template.find('input, select').each(function() {
                var name = $(this).attr('name');
                if (name && name.indexOf('schedules[') >= 0) {
                    $(this).attr('name', name.replace(/schedules\[\d+\]/, 'schedules[' +
                        bulkIndex + ']'));
                }
                if ($(this).is('input[type="text"]') || $(this).is('input[type="time"]') || $(
                        this).is('input[type="number"]')) {
                    $(this).val('');
                } else if ($(this).is('select')) {
                    $(this).prop('selectedIndex', 0);
                }
            });
            var removeBtn =
                '<button type="button" class="btn-remove-item" onclick="removeBulkItem(this)"><i class="fas fa-trash-alt"></i> Hapus</button>';
            template.append(removeBtn);
            container.append(template);
            bulkIndex++;
            $('html, body').animate({
                scrollTop: template.offset().top - 100
            }, 300);
        });

        window.removeBulkItem = function(btn) {
            if (confirm('Hapus jadwal ini?')) {
                $(btn).closest('.bulk-schedule-item').remove();
                reindexBulk();
            }
        };

        function reindexBulk() {
            var index = 0;
            $('.bulk-schedule-item').each(function() {
                $(this).attr('data-index', index);
                $(this).find('.item-number').text(index + 1);
                $(this).find('input, select').each(function() {
                    var name = $(this).attr('name');
                    if (name && name.indexOf('schedules[') >= 0) {
                        $(this).attr('name', name.replace(/schedules\[\d+\]/, 'schedules[' +
                            index + ']'));
                    }
                });
                index++;
            });
            bulkIndex = index;
        }

        $('#bulkAddForm').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btnBulkSave');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        $('#bulkAddModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('error', response.message);
                        btn.prop('disabled', false).html(
                            '<i class="fas fa-save me-1"></i> Simpan Semua');
                    }
                },
                error: function(xhr) {
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr
                        .responseJSON.message : 'Terjadi kesalahan.';
                    showNotification('error', msg);
                    btn.prop('disabled', false).html(
                        '<i class="fas fa-save me-1"></i> Simpan Semua');
                }
            });
        });

        $('#editScheduleForm').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btnUpdateSchedule');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        $('#editModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function(xhr) {
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr
                        .responseJSON.message : 'Terjadi kesalahan.';
                    showNotification('error', msg);
                },
                complete: function() {
                    btn.prop('disabled', false).html(
                        '<i class="fas fa-save me-1"></i> Perbarui');
                }
            });
        });

        $('#btnDeleteAll').click(function(e) {
            e.preventDefault();
            if (confirm('Yakin hapus SEMUA data jadwal? Tindakan ini tidak dapat dibatalkan.')) {
                $.ajax({
                    url: '{{ url('/admin/manage-schedule/delete-all') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification('success', response.message);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showNotification('error', response.message);
                        }
                    },
                    error: function() {
                        showNotification('error', 'Terjadi kesalahan.');
                    }
                });
            }
        });
    });
</script>

<!-- Bulk Add Modal -->
<div class="modal fade" id="bulkAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <form method="POST" action="{{ url('/admin/manage-schedule/store-bulk') }}" id="bulkAddForm">
                @csrf
                <div class="modal-header-modern d-flex align-items-center justify-content-between">
                    <h5 class="modal-title">
                        <i class="fas fa-layer-group me-2"></i> Tambah Jadwal Massal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern">
                    <div class="alert-flash info"
                        style="background:var(--nb-teal);color:var(--nb-black);margin-bottom:20px;">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            <strong>Input Multiple Jadwal:</strong> Tambahkan beberapa jadwal sekaligus dengan mengisi
                            form di bawah ini. Klik tombol <strong>"Tambah Form"</strong> untuk menambahkan entri baru.
                        </div>
                    </div>

                    <div id="bulkSchedulesContainer">
                        <div class="bulk-schedule-item" data-index="0">
                            <div class="modal-section-title">
                                <i class="fas fa-calendar-alt"></i> Jadwal ke-<span class="item-number">1</span>
                            </div>
                            <div class="form-row-enhanced">
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Kelas</label>
                                    <span class="input-icon-left"><i class="fas fa-users"></i></span>
                                    <input type="text" name="schedules[0][kelas]" class="form-control-custom"
                                        required placeholder="Contoh: TI-1A">
                                </div>
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Hari</label>
                                    <span class="input-icon-left"><i class="fas fa-calendar-day"></i></span>
                                    <select name="schedules[0][hari]" class="form-select-custom" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="SENIN">SENIN</option>
                                        <option value="SELASA">SELASA</option>
                                        <option value="RABU">RABU</option>
                                        <option value="KAMIS">KAMIS</option>
                                        <option value="JUMAT">JUMAT</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row-enhanced three-cols">
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Jam Ke</label>
                                    <span class="input-icon-left"><i class="fas fa-hashtag"></i></span>
                                    <input type="number" name="schedules[0][jam_ke]" class="form-control-custom"
                                        min="1" max="10" required placeholder="1-10">
                                </div>
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Waktu Mulai</label>
                                    <span class="input-icon-left"><i class="fas fa-play"></i></span>
                                    <input type="time" name="schedules[0][waktu_mulai]"
                                        class="form-control-custom" required>
                                </div>
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Waktu Selesai</label>
                                    <span class="input-icon-left"><i class="fas fa-stop"></i></span>
                                    <input type="time" name="schedules[0][waktu_selesai]"
                                        class="form-control-custom" required>
                                </div>
                            </div>

                            <div class="form-row-enhanced">
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Mata Kuliah</label>
                                    <span class="input-icon-left"><i class="fas fa-book-open"></i></span>
                                    <input type="text" name="schedules[0][mata_kuliah]"
                                        class="form-control-custom" required placeholder="Nama mata kuliah">
                                </div>
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Dosen</label>
                                    <span class="input-icon-left"><i class="fas fa-user-tie"></i></span>
                                    <input type="text" name="schedules[0][dosen]" class="form-control-custom"
                                        required placeholder="Nama dosen">
                                </div>
                            </div>

                            <div class="form-row-enhanced three-cols">
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Ruang</label>
                                    <span class="input-icon-left"><i class="fas fa-door-open"></i></span>
                                    <select name="schedules[0][ruang]" class="form-select-custom" required>
                                        <option value="">Pilih Ruang</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room }}">{{ $room }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label-custom">Semester</label>
                                    <input type="text" name="schedules[0][semester]" class="form-control-custom"
                                        value="{{ $semesterAktif }}" readonly>
                                    <span class="readonly-badge"><i class="fas fa-lock"></i> Otomatis</span>
                                </div>
                                <div class="input-icon-wrapper">
                                    <label class="form-label-custom">Tahun Akademik</label>
                                    <span class="input-icon-left"><i class="fas fa-graduation-cap"></i></span>
                                    <input type="text" name="schedules[0][tahun_akademik]"
                                        class="form-control-custom" value="{{ $tahunAkademikAktif }}" readonly>
                                    <span class="readonly-badge"><i class="fas fa-lock"></i> Otomatis</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-outline-secondary-custom" id="btnAddMoreSchedule"
                        style="width:100%;justify-content:center;margin-top:10px;">
                        <i class="fas fa-plus"></i> Tambah Form
                    </button>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal-primary" id="btnBulkSave">
                        <i class="fas fa-save me-1"></i> Simpan Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bulk-schedule-item {
        background: var(--nb-offwhite);
        border: var(--nb-border);
        border-radius: var(--nb-radius);
        padding: 20px;
        margin-bottom: 16px;
        position: relative;
    }

    .bulk-schedule-item .item-number {
        background: var(--nb-yellow);
        padding: 4px 12px;
        border-radius: var(--nb-radius-sm);
        border: 2px solid var(--nb-black);
        box-shadow: var(--nb-shadow-sm);
        font-weight: 700;
    }

    .btn-remove-item {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--nb-red);
        color: var(--nb-white);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        padding: 8px 14px;
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: var(--nb-shadow-sm);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-remove-item:hover {
        background: var(--nb-black);
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
    }

    .bulk-schedule-item:first-child .btn-remove-item {
        display: none !important;
    }
</style>

<!-- Delete All Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern d-flex align-items-center justify-content-between"
                style="border-color:var(--nb-red);">
                <h5 class="modal-title" style="color:var(--nb-white);">
                    <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <div class="text-center mb-4">
                    <i class="fas fa-trash-alt"
                        style="font-size:3rem;color:var(--nb-red);margin-bottom:12px;display:block;"></i>
                    <h5 style="font-weight:700;color:var(--nb-red);font-size:1.1rem;text-transform:uppercase;">
                        PERINGATAN!
                    </h5>
                </div>
                <div
                    style="background:var(--nb-red);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:16px;margin-bottom:20px;color:var(--nb-white);">
                    <h6 style="font-size:0.85rem;font-weight:700;color:var(--nb-white);margin-bottom:8px;">
                        <i class="fas fa-exclamation-circle me-2"></i>Tindakan ini akan:
                    </h6>
                    <ul style="margin-bottom:0;padding-left:20px;font-size:0.85rem;font-weight:600;">
                        <li>Menghapus <strong>SEMUA {{ count($schedules) }} data</strong> jadwal</li>
                        <li>Data yang dihapus <strong>TIDAK DAPAT DIPULIHKAN</strong></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer-modern d-flex justify-content-between">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form method="POST" action="{{ url('/admin/manage-schedule/delete-all') }}">
                    @csrf
                    <button type="submit" class="btn-destructive-outline">
                        <i class="fas fa-trash-alt me-1"></i> Ya, Hapus Semua!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .parallel-modal .info-box {
        background: var(--nb-offwhite);
        border: var(--nb-border);
        border-radius: var(--nb-radius-sm);
        padding: 14px 16px;
        margin-bottom: 18px;
        box-shadow: var(--nb-shadow-sm);
    }

    .parallel-modal .info-box .info-row {
        display: flex;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .parallel-modal .info-box .info-row:last-child {
        margin-bottom: 0;
    }

    .parallel-modal .info-box .info-label {
        min-width: 110px;
        color: var(--nb-dark);
        font-weight: 700;
    }

    .parallel-modal .current-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--nb-orange);
        color: var(--nb-black);
        border: 2px solid var(--nb-black);
        border-radius: 6px;
        padding: 5px 12px;
        font-family: var(--font-display);
        font-size: 0.8rem;
        font-weight: 700;
        margin: 4px;
        box-shadow: var(--nb-shadow-sm);
    }

    .parallel-modal .current-badge .remove-badge {
        background: var(--nb-red);
        color: var(--nb-white);
        border: 2px solid var(--nb-black);
        border-radius: 4px;
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        cursor: pointer;
        line-height: 1;
    }

    .parallel-modal .current-badge .remove-badge:hover {
        background: var(--nb-black);
        color: var(--nb-white);
    }
</style>

<!-- Parallel Add Modal (tambahkan kelas pada jadwal yang sudah ada) -->
<div class="modal fade" id="parallelAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-modern parallel-modal">
            <div class="modal-header-modern d-flex align-items-center justify-content-between">
                <h5 class="modal-title">
                    <i class="fas fa-layer-group me-2"></i> Kelas Paralel Jadwal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <div class="modal-section-title">
                    <i class="fas fa-info-circle"></i> Jadwal Dasar
                </div>
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Kelas Utama</span>
                        <span id="parallel_base_kelas"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mata Kuliah</span>
                        <span id="parallel_mata_kuliah"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Hari / Jam</span>
                        <span id="parallel_hari_jam"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waktu</span>
                        <span id="parallel_waktu"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dosen / Ruang</span>
                        <span id="parallel_dosen_ruang"></span>
                    </div>
                </div>

                <div class="modal-section-title" style="margin-top:18px;">
                    <i class="fas fa-users"></i> Kelas Paralel Saat Ini
                </div>
                <div id="parallelCurrentList" class="mb-3">
                    <em style="color:var(--nb-dark);">Belum ada kelas paralel.</em>
                </div>

                <hr class="form-divider">

                <div class="modal-section-title">
                    <i class="fas fa-plus-circle"></i> Tambah Kelas Paralel
                </div>
                <form id="parallelAddForm" method="POST" action="{{ url('/admin/manage-parallel/store') }}">
                    @csrf
                    <input type="hidden" name="schedule_id" id="parallel_schedule_id">
                    <input type="hidden" name="kelas" id="parallel_kelas_input">
                    <div class="input-icon-wrapper">
                        <label class="form-label-custom">Kelas Tambahan <small style="font-weight:400;">(dari database)</small></label>
                        <div id="parallelKelasOptions" class="form-control-custom" style="max-height:180px;overflow-y:auto;padding:10px;">
                            <em style="color:var(--nb-dark);">Memuat daftar kelas...</em>
                        </div>
                    </div>
                    <div class="form-hint" style="margin-top:8px;">
                        <i class="fas fa-shield-alt"></i> Sistem otomatis menolak jika kelas tambahan sudah memiliki
                        jadwal yang bentrok.
                    </div>
                    <div class="modal-footer-modern" style="margin-top:20px;padding:0;">
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn-modal-primary" id="btnSaveParallel">
                            <i class="fas fa-plus me-1"></i> Tambah Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var kelasDbList = @json($kelasList ?? []);

    function openParallelModal(schedule, currentKelas) {
        document.getElementById('parallel_schedule_id').value = schedule.id;
        document.getElementById('parallel_base_kelas').textContent = schedule.kelas || '-';
        document.getElementById('parallel_mata_kuliah').textContent = schedule.mata_kuliah || '-';
        document.getElementById('parallel_hari_jam').textContent = (schedule.hari || '-') + ' | Jam ke-' + (schedule
            .jam_ke || '-');
        document.getElementById('parallel_waktu').textContent = schedule.waktu || '-';
        document.getElementById('parallel_dosen_ruang').textContent = (schedule.dosen || '-') + ' | ' + (schedule
            .ruang || '-');
        renderParallelKelasOptions(schedule, currentKelas || []);
        renderParallelList(schedule.id, currentKelas || [], schedule);
        var modal = new bootstrap.Modal(document.getElementById('parallelAddModal'));
        modal.show();
    }

    function renderParallelKelasOptions(schedule, currentKelas) {
        var container = document.getElementById('parallelKelasOptions');
        var baseKelas = String(schedule.kelas || '').trim();
        var excluded = [baseKelas.toLowerCase()].concat(
            (currentKelas || []).map(function(k) { return String(k).trim().toLowerCase(); })
        );
        var available = (kelasDbList || []).filter(function(k) {
            return excluded.indexOf(String(k).trim().toLowerCase()) === -1;
        });
        if (available.length === 0) {
            container.innerHTML = '<em style="color:var(--nb-dark);">Tidak ada kelas lain yang tersedia di database.</em>';
            return;
        }
        var html = '';
        available.forEach(function(k, i) {
            var safeK = String(k).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            html += '<label style="display:flex;align-items:center;gap:8px;padding:4px 2px;cursor:pointer;">' +
                '<input type="checkbox" class="parallel-kelas-check form-check-input mt-0" value="' + safeK + '">' +
                '<span style="font-weight:600;">' + safeK + '</span></label>';
        });
        container.innerHTML = html;
    }

    function syncParallelKelasInput() {
        var selected = [];
        document.querySelectorAll('#parallelKelasOptions .parallel-kelas-check:checked').forEach(function(cb) {
            selected.push(cb.value);
        });
        document.getElementById('parallel_kelas_input').value = selected.join(', ');
        return selected;
    }

    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList && e.target.classList.contains('parallel-kelas-check')) {
            syncParallelKelasInput();
        }
    });

    function renderParallelList(scheduleId, list, schedule) {
        var container = document.getElementById('parallelCurrentList');
        if (!list || list.length === 0) {
            container.innerHTML = '<em style="color:var(--nb-dark);">Belum ada kelas paralel.</em>';
            return;
        }
        var html = '';
        list.forEach(function(k) {
            var safeK = String(k).replace(/'/g, "");
            html += '<span class="current-badge">' + k +
                '<span class="remove-badge" title="Hapus kelas ini" onclick="removeParallelClass(' + scheduleId + ', \'' +
                safeK + '\')">×</span></span>';
        });
        container.innerHTML = html;
    }

    function removeParallelClass(scheduleId, kelas) {
        if (!confirm('Hapus kelas ' + kelas + ' dari jadwal paralel ini?')) return;
        $.ajax({
            url: '{{ url('/admin/manage-parallel/remove-class') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                schedule_id: scheduleId,
                kelas: kelas
            },
            success: function(response) {
                if (response.success) {
                    if (typeof showNotification === 'function') {
                        showNotification('success', response.message);
                    }
                    setTimeout(function() {
                        if (window.location.pathname.indexOf('/admin/manage-parallel') !== -1) {
                            location.reload();
                        } else {
                            window.location.href = '{{ url('/admin/manage-parallel') }}';
                        }
                    }, 800);
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification('error', response.message);
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function() {
                if (typeof showNotification === 'function') {
                    showNotification('error', 'Terjadi kesalahan.');
                } else {
                    alert('Terjadi kesalahan.');
                }
            }
        });
    }

    $(document).ready(function() {
        // Delegated handler untuk tombol Paralel (aman terhadap re-render tabel)
        $(document).on('click', '.btn-parallel', function() {
            var schedule;
            try {
                schedule = JSON.parse($(this).attr('data-schedule'));
            } catch (err) {
                console.error('Data jadwal tidak valid:', err);
                return;
            }
            var kelasStr = $(this).attr('data-kelas') || '';
            var currentKelas = kelasStr.split(',').map(function(s) { return s.trim(); }).filter(Boolean);
            openParallelModal(schedule, currentKelas);
        });

        $('#parallelAddForm').on('submit', function(e) {
            e.preventDefault();
            var selected = syncParallelKelasInput();
            if (selected.length === 0) {
                if (typeof showNotification === 'function') {
                    showNotification('error', 'Pilih minimal satu kelas.');
                } else {
                    alert('Pilih minimal satu kelas.');
                }
                return;
            }
            var btn = $('#btnSaveParallel');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        if (typeof showNotification === 'function') {
                            showNotification('success', response.message);
                        }
                        $('#parallelAddModal').modal('hide');
                        setTimeout(function() {
                            if (window.location.pathname.indexOf('/admin/manage-parallel') !== -1) {
                                location.reload();
                            } else {
                                window.location.href = '{{ url('/admin/manage-parallel') }}';
                            }
                        }, 1000);
                    } else {
                        if (typeof showNotification === 'function') {
                            showNotification('error', response.message);
                        } else {
                            alert(response.message);
                        }
                    }
                },
                error: function(xhr) {
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message :
                        'Terjadi kesalahan.';
                    if (typeof showNotification === 'function') {
                        showNotification('error', msg);
                    } else {
                        alert(msg);
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-plus me-1"></i> Tambah Kelas');
                }
            });
        });
    });
</script>
