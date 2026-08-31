<style>
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

    .btn-destructive-outline {
        padding: 12px 28px;
        background: var(--nb-white);
        color: var(--nb-red);
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

    .btn-destructive-outline:hover {
        background: var(--nb-red);
        color: var(--nb-white);
        transform: translate(-2px, -2px);
        box-shadow: var(--nb-shadow);
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
                        <li>Menghapus <strong>SEMUA {{ count($schedules) }} data</strong> jadwal paralel</li>
                        <li>Data yang dihapus <strong>TIDAK DAPAT DIPULIHKAN</strong></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer-modern d-flex justify-content-between">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form method="POST" action="{{ url('/admin/manage-parallel/delete-all') }}">
                    @csrf
                    <button type="submit" class="btn-destructive-outline">
                        <i class="fas fa-trash-alt me-1"></i> Ya, Hapus Semua!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>