<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form method="POST" action="{{ url('/admin/manage-schedule/store') }}" id="addScheduleForm">
                @csrf
                <div class="modal-header-custom d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                        <i class="fas fa-plus me-2" style="color:var(--corporate-blue);"></i> Tambah Jadwal Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-custom">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Kelas</label>
                            <input type="text" name="kelas" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Hari</label>
                            <select name="hari" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                <option value="">Pilih Hari</option>
                                <option value="SENIN">SENIN</option>
                                <option value="SELASA">SELASA</option>
                                <option value="RABU">RABU</option>
                                <option value="KAMIS">KAMIS</option>
                                <option value="JUMAT">JUMAT</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Jam
                                Ke</label>
                            <input type="number" name="jam_ke" class="form-control" min="1" max="10"
                                required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Waktu
                                Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Waktu
                                Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Mata
                                Kuliah</label>
                            <input type="text" name="mata_kuliah" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Dosen</label>
                            <input type="text" name="dosen" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Ruang</label>
                            <select name="ruang" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                <option value="">Pilih Ruang</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room }}">{{ $room }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Semester</label>
                            <input type="text" name="semester" class="form-control" value="{{ $semesterAktif }}"
                                readonly
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;background:#f4f4f5;color:var(--zinc-600);">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Tahun
                                Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control"
                                value="{{ $tahunAkademikAktif }}" readonly
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;background:#f4f4f5;color:var(--zinc-600);">
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom"
                    style="padding:16px 24px;border-top:1px solid var(--zinc-100);display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" class="btn-outline-secondary-custom" data-bs-dismiss="modal"
                        style="padding:8px 20px;">Batal</button>
                    <button type="submit" class="btn-primary-solid" style="padding:8px 20px;" id="btnSaveSchedule">
                        <i class="fas fa-save me-2"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form method="POST" action="" id="editScheduleForm">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header-custom d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                        <i class="fas fa-edit me-2" style="color:var(--corporate-blue);"></i> Edit Jadwal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-custom">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Kelas</label>
                            <input type="text" name="kelas" id="edit_kelas" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Hari</label>
                            <select name="hari" id="edit_hari" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                <option value="">Pilih Hari</option>
                                <option value="SENIN">SENIN</option>
                                <option value="SELASA">SELASA</option>
                                <option value="RABU">RABU</option>
                                <option value="KAMIS">KAMIS</option>
                                <option value="JUMAT">JUMAT</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Jam
                                Ke</label>
                            <input type="number" name="jam_ke" id="edit_jam_ke" class="form-control"
                                min="1" max="10" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Waktu
                                Mulai</label>
                            <input type="time" name="waktu_mulai" id="edit_waktu_mulai" class="form-control"
                                required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Waktu
                                Selesai</label>
                            <input type="time" name="waktu_selesai" id="edit_waktu_selesai" class="form-control"
                                required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Mata
                                Kuliah</label>
                            <input type="text" name="mata_kuliah" id="edit_mata_kuliah" class="form-control"
                                required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Dosen</label>
                            <input type="text" name="dosen" id="edit_dosen" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Ruang</label>
                            <select name="ruang" id="edit_ruang" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                <option value="">Pilih Ruang</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room }}">{{ $room }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Semester</label>
                            <select name="semester" id="edit_semester" class="form-control" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                <option value="GANJIL">GANJIL</option>
                                <option value="GENAP">GENAP</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Tahun
                                Akademik</label>
                            <input type="text" name="tahun_akademik" id="edit_tahun_akademik"
                                class="form-control" placeholder="Contoh: 2024/2025" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom"
                    style="padding:16px 24px;border-top:1px solid var(--zinc-100);display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" class="btn-outline-secondary-custom" data-bs-dismiss="modal"
                        style="padding:8px 20px;">Batal</button>
                    <button type="submit" class="btn-primary-solid" style="padding:8px 20px;"
                        id="btnUpdateSchedule">
                        <i class="fas fa-save me-2"></i> Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Notification function
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

    // Global editSchedule function
    function editSchedule(data) {
        // Populate the edit modal fields
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_kelas').value = data.kelas;
        document.getElementById('edit_hari').value = data.hari;
        document.getElementById('edit_jam_ke').value = data.jam_ke;
        document.getElementById('edit_mata_kuliah').value = data.mata_kuliah;
        document.getElementById('edit_dosen').value = data.dosen;
        document.getElementById('edit_semester').value = data.semester;
        document.getElementById('edit_tahun_akademik').value = data.tahun_akademik;

        // Parse waktu to get waktu_mulai and waktu_selesai
        if (data.waktu) {
            var waktuParts = data.waktu.split(' - ');
            if (waktuParts.length === 2) {
                document.getElementById('edit_waktu_mulai').value = waktuParts[0].trim();
                document.getElementById('edit_waktu_selesai').value = waktuParts[1].trim();
            }
        }

        // Set room dropdown
        document.getElementById('edit_ruang').value = data.ruang;

        // Set form action URL with the schedule ID
        document.getElementById('editScheduleForm').action = '{{ url('/admin/manage-schedule/update') }}/' + data.id;

        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    $(document).ready(function() {
        $('#addScheduleForm').on('submit', function(e) {
            e.preventDefault();

            var btn = $('#btnSaveSchedule');
            var originalText = btn.html();
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        $('#addModal').modal('hide');
                        $('#addScheduleForm')[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function() {
                    showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            });
        });

        // Edit form AJAX submission
        $('#editScheduleForm').on('submit', function(e) {
            e.preventDefault();

            var btn = $('#btnUpdateSchedule');
            var originalText = btn.html();
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        $('#editModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function(xhr) {
                    var msg = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    showNotification('error', msg);
                },
                complete: function() {
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            });
        });

        // Delete All AJAX
        $('#btnDeleteAll').on('click', function() {
            if (!confirm('Yakin hapus SEMUA data jadwal? Tindakan ini tidak dapat dibatalkan.')) {
                return false;
            }

            var btn = $(this);
            var originalText = btn.html();

            $.ajax({
                url: '{{ url('/admin/manage-schedule/delete-all') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function() {
                    showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>

<!-- Bulk Add Modal -->
<div class="modal fade" id="bulkAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form method="POST" action="{{ url('/admin/manage-schedule/bulk-store') }}">
                @csrf
                <div class="modal-header-custom d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                        <i class="fas fa-layer-group me-2" style="color:var(--corporate-blue);"></i> Tambah Jadwal
                        Massal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-custom">
                    <div class="alert alert-info"
                        style="background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;border-radius:10px;padding:14px 18px;font-size:0.85rem;">
                        <i class="fas fa-info-circle me-2"></i> Masukkan data jadwal dalam format CSV dengan kolom:
                        Kelas, Hari, Jam Ke, Waktu Mulai, Waktu Selesai, Mata Kuliah, Dosen, Ruang, Semester, Tahun
                        Akademik
                    </div>
                    <div class="mb-3">
                        <label
                            style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Data
                            CSV</label>
                        <textarea name="bulk_data" class="form-control" rows="10"
                            placeholder="Kelas,Hari,Jam Ke,Waktu Mulai,Waktu Selesai,Mata Kuliah,Dosen,Ruang,Semester,Tahun Akademik&#10;TI-1A,SENIN,1,08:00,09:40,Pemrograman Web,John Doe,R-101,GANJIL,2024/2025"
                            required
                            style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"></textarea>
                    </div>
                </div>
                <div class="modal-footer-custom"
                    style="padding:16px 24px;border-top:1px solid var(--zinc-100);display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" class="btn-outline-secondary-custom" data-bs-dismiss="modal"
                        style="padding:8px 20px;">Batal</button>
                    <button type="submit" class="btn-primary-solid" style="padding:8px 20px;"><i
                            class="fas fa-upload me-2"></i> Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete All Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header-custom d-flex align-items-center justify-content-between"
                style="border-color:#fecaca;">
                <h5 class="modal-title" style="font-weight:700;font-size:1rem;color:#b91c1c;">
                    <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-custom">
                <div class="text-center mb-4">
                    <i class="fas fa-trash-alt"
                        style="font-size:3rem;color:#fca5a5;margin-bottom:12px;display:block;"></i>
                    <h5 style="font-weight:700;color:#b91c1c;font-size:1.1rem;">PERINGATAN!</h5>
                </div>
                <div
                    style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:16px;margin-bottom:20px;">
                    <h6 style="font-size:0.85rem;font-weight:600;color:#991b1b;margin-bottom:8px;"><i
                            class="fas fa-exclamation-circle me-2"></i>Tindakan ini akan:</h6>
                    <ul style="margin-bottom:0;padding-left:20px;font-size:0.85rem;color:#991b1b;">
                        <li>Menghapus <strong>SEMUA {{ count($schedules) }} data</strong> jadwal</li>
                        <li>Data yang dihapus <strong>TIDAK DAPAT DIPULIHKAN</strong></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer-custom"
                style="padding:16px 24px;border-top:1px solid var(--zinc-100);display:flex;justify-content:space-between;">
                <button type="button" class="btn-outline-secondary-custom" data-bs-dismiss="modal"
                    style="padding:8px 20px;">Batal</button>
                <form method="POST" action="{{ url('/admin/manage-schedule/delete-all') }}">
                    @csrf
                    <button type="submit" class="btn-destructive-outline" style="padding:8px 20px;"><i
                            class="fas fa-trash-alt me-2"></i> Ya, Hapus Semua!</button>
                </form>
            </div>
        </div>
    </div>
</div>
