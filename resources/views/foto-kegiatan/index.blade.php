@extends('layouts.espire-app')

@section('content')
    @php
        $globalIndex = 0;
    @endphp

    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Foto Kegiatan</h2>
                @if (auth()->user()?->hasFeatureAccess('foto_kegiatan.create'))
                    <a href="{{ route('foto-kegiatan.create') }}" class="btn btn-primary">Tambah Foto Kegiatan</a>
                @endif
            </div>
        </div>

        @if ($missingFileCount > 0)
            <div class="alert alert-warning" role="alert">
                {{ $missingFileCount }} foto tidak dapat ditampilkan karena berkasnya tidak ditemukan di penyimpanan server (mungkin belum tersinkron atau terhapus). Foto ditandai dengan ikon "Tidak ditemukan" di bawah.
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                @forelse ($groupedByDate as $group)
                    <div class="foto-date-group">
                        <div class="foto-date-group-header">
                            <h5 class="mb-0">{{ $group['label'] }}</h5>
                            <span class="text-muted small">{{ $group['items']->count() }} foto</span>
                        </div>

                        <div class="foto-gallery-grid">
                            @foreach ($group['items'] as $item)
                                @php
                                    $index = $globalIndex++;
                                @endphp
                                <div class="foto-gallery-item {{ $item->file_exists ? '' : 'is-missing' }}" data-index="{{ $index }}">
                                    @if ($item->file_exists)
                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto kegiatan" loading="lazy">
                                    @else
                                        <div class="foto-gallery-missing">
                                            <i class="feather icon-image"></i>
                                            <span>Tidak ditemukan</span>
                                        </div>
                                    @endif
                                    <div class="foto-gallery-item-caption">{{ $item->kegiatan?->nama_kegiatan ?? '-' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-3">Belum ada data foto kegiatan.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="foto-lightbox" class="foto-lightbox" hidden>
        <div class="foto-lightbox-topbar">
            <div>
                <div class="foto-lightbox-title" id="foto-lightbox-title"></div>
                <div class="foto-lightbox-counter"><span id="foto-lightbox-current">1</span> / <span id="foto-lightbox-total">1</span></div>
            </div>
            <button type="button" class="foto-lightbox-close" aria-label="Tutup pratinjau">&times;</button>
        </div>
        <button type="button" class="foto-lightbox-nav foto-lightbox-prev" aria-label="Foto sebelumnya">&#10094;</button>
        <div class="foto-lightbox-stage" id="foto-lightbox-stage">
            <img id="foto-lightbox-img" src="" alt="Pratinjau foto kegiatan" draggable="false">
            <div id="foto-lightbox-missing" class="foto-lightbox-missing-msg" hidden>
                <i class="feather icon-image"></i>
                <span>Berkas foto tidak ditemukan di server.</span>
            </div>
        </div>
        <button type="button" class="foto-lightbox-nav foto-lightbox-next" aria-label="Foto berikutnya">&#10095;</button>

        <div class="foto-lightbox-bottombar">
            <div class="foto-lightbox-keterangan" id="foto-lightbox-keterangan"></div>
            <div class="foto-lightbox-actions">
                <a id="foto-lightbox-download" href="#" class="btn btn-sm btn-success">Download</a>
                @if ($canEdit)
                    <a id="foto-lightbox-edit" href="#" class="btn btn-sm btn-warning">Edit</a>
                @endif
                @if ($canDelete)
                    <button type="button" id="foto-lightbox-delete" class="btn btn-sm btn-danger">Hapus</button>
                @endif
            </div>
        </div>
    </div>

    @if ($canDelete)
        <form id="foto-delete-form" method="POST" action="" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <style>
        .foto-date-group {
            margin-bottom: 28px;
        }

        .foto-date-group:last-child {
            margin-bottom: 0;
        }

        .foto-date-group-header {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e3e8ee;
        }

        .foto-gallery-grid {
            columns: 5 170px;
            column-gap: 12px;
        }

        @media (max-width: 576px) {
            .foto-gallery-grid {
                columns: 2 140px;
            }
        }

        .foto-gallery-item {
            position: relative;
            break-inside: avoid;
            margin-bottom: 12px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e3e8ee;
            background: #fff;
            cursor: zoom-in;
        }

        .foto-gallery-item img {
            display: block;
            width: 100%;
            height: auto;
        }

        .foto-gallery-item-caption {
            font-size: 11px;
            color: #6c7683;
            padding: 4px 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .foto-gallery-missing {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 130px;
            background: #f3f4f6;
            color: #9aa4b2;
            font-size: 12px;
        }

        .foto-gallery-missing i {
            font-size: 22px;
        }

        .foto-gallery-item.is-missing {
            cursor: default;
        }

        .foto-lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .92);
            z-index: 2000;
            display: flex;
            flex-direction: column;
        }

        .foto-lightbox[hidden] {
            display: none;
        }

        .foto-lightbox-topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 12px 16px;
            color: #fff;
        }

        .foto-lightbox-title {
            font-weight: 600;
        }

        .foto-lightbox-counter {
            font-size: 13px;
            opacity: .75;
        }

        .foto-lightbox-close {
            background: none;
            border: none;
            color: #fff;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
        }

        .foto-lightbox-stage {
            flex: 1;
            position: relative;
            overflow: hidden;
            touch-action: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .foto-lightbox-stage img {
            max-width: 100%;
            max-height: 100%;
            user-select: none;
            -webkit-user-drag: none;
            will-change: transform;
            touch-action: none;
        }

        .foto-lightbox-missing-msg {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: #9aa4b2;
        }

        .foto-lightbox-missing-msg i {
            font-size: 40px;
        }

        .foto-lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, .12);
            border: none;
            color: #fff;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            z-index: 5;
        }

        .foto-lightbox-nav:hover {
            background: rgba(255, 255, 255, .25);
        }

        .foto-lightbox-prev {
            left: 12px;
        }

        .foto-lightbox-next {
            right: 12px;
        }

        .foto-lightbox-bottombar {
            padding: 12px 16px 18px;
            color: #fff;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 12px;
        }

        .foto-lightbox-keterangan {
            font-size: 13px;
            opacity: .85;
            max-width: 70%;
            max-height: 4.5em;
            overflow-y: auto;
        }

        .foto-lightbox-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }
    </style>

    <script>
        (function () {
            'use strict';

            const photos = @json($photosForJs);

            if (!photos.length) return;

            const lightbox = document.getElementById('foto-lightbox');
            const lightboxStage = document.getElementById('foto-lightbox-stage');
            const lightboxImg = document.getElementById('foto-lightbox-img');
            const lightboxMissing = document.getElementById('foto-lightbox-missing');
            const lightboxTitle = document.getElementById('foto-lightbox-title');
            const lightboxKeterangan = document.getElementById('foto-lightbox-keterangan');
            const lightboxCurrent = document.getElementById('foto-lightbox-current');
            const lightboxTotal = document.getElementById('foto-lightbox-total');
            const closeBtn = lightbox.querySelector('.foto-lightbox-close');
            const prevBtn = lightbox.querySelector('.foto-lightbox-prev');
            const nextBtn = lightbox.querySelector('.foto-lightbox-next');
            const downloadBtn = document.getElementById('foto-lightbox-download');
            const editBtn = document.getElementById('foto-lightbox-edit');
            const deleteBtn = document.getElementById('foto-lightbox-delete');
            const deleteForm = document.getElementById('foto-delete-form');

            let currentIndex = 0;
            let scale = 1;
            let panX = 0;
            let panY = 0;

            const MIN_SCALE = 1;
            const MAX_SCALE = 4;

            function applyTransform() {
                lightboxImg.style.transform = 'translate(' + panX + 'px, ' + panY + 'px) scale(' + scale + ')';
            }

            function resetTransform() {
                scale = 1;
                panX = 0;
                panY = 0;
                applyTransform();
            }

            function clampPan() {
                if (scale <= 1) {
                    panX = 0;
                    panY = 0;
                    return;
                }

                const stageRect = lightboxStage.getBoundingClientRect();
                const maxX = (stageRect.width * (scale - 1)) / 2;
                const maxY = (stageRect.height * (scale - 1)) / 2;

                panX = Math.min(maxX, Math.max(-maxX, panX));
                panY = Math.min(maxY, Math.max(-maxY, panY));
            }

            function renderPhoto(index) {
                const photo = photos[index];

                resetTransform();
                lightboxTitle.textContent = photo.kegiatan;
                lightboxKeterangan.textContent = photo.keterangan;
                lightboxCurrent.textContent = index + 1;
                lightboxTotal.textContent = photos.length;

                if (photo.exists) {
                    lightboxImg.src = photo.url;
                    lightboxImg.hidden = false;
                    lightboxMissing.hidden = true;
                } else {
                    lightboxImg.hidden = true;
                    lightboxMissing.hidden = false;
                }

                if (downloadBtn) {
                    if (photo.downloadUrl) {
                        downloadBtn.href = photo.downloadUrl;
                        downloadBtn.classList.remove('disabled');
                    } else {
                        downloadBtn.href = '#';
                        downloadBtn.classList.add('disabled');
                    }
                }

                if (editBtn) editBtn.href = photo.editUrl || '#';
                if (deleteBtn) deleteBtn.dataset.deleteUrl = photo.deleteUrl || '';
            }

            function openLightbox(index) {
                currentIndex = index;
                renderPhoto(currentIndex);
                lightbox.hidden = false;
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.hidden = true;
                document.body.style.overflow = '';
            }

            function showPhoto(index) {
                currentIndex = (index + photos.length) % photos.length;
                renderPhoto(currentIndex);
            }

            function nextPhoto() { showPhoto(currentIndex + 1); }
            function prevPhoto() { showPhoto(currentIndex - 1); }

            document.querySelectorAll('.foto-gallery-item').forEach((el) => {
                if (el.classList.contains('is-missing')) return;
                el.addEventListener('click', () => openLightbox(parseInt(el.dataset.index, 10)));
            });

            closeBtn.addEventListener('click', closeLightbox);
            nextBtn.addEventListener('click', nextPhoto);
            prevBtn.addEventListener('click', prevPhoto);

            if (deleteBtn && deleteForm) {
                deleteBtn.addEventListener('click', () => {
                    const url = deleteBtn.dataset.deleteUrl;
                    if (!url) return;
                    if (!confirm('Hapus foto kegiatan ini?')) return;
                    deleteForm.action = url;
                    deleteForm.submit();
                });
            }

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            document.addEventListener('keydown', (e) => {
                if (lightbox.hidden) return;
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowRight') nextPhoto();
                if (e.key === 'ArrowLeft') prevPhoto();
            });

            lightboxStage.addEventListener('wheel', (e) => {
                if (!e.ctrlKey) return;
                e.preventDefault();

                const delta = -e.deltaY * 0.01;
                scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, scale + delta));
                clampPan();
                applyTransform();
            }, { passive: false });

            const activePointers = new Map();
            let pinchStartDistance = 0;
            let pinchStartScale = 1;
            let panStart = null;
            let swipeStart = null;

            function pointerDistance() {
                const pts = Array.from(activePointers.values());
                const dx = pts[0].x - pts[1].x;
                const dy = pts[0].y - pts[1].y;
                return Math.hypot(dx, dy);
            }

            lightboxStage.addEventListener('pointerdown', (e) => {
                activePointers.set(e.pointerId, { x: e.clientX, y: e.clientY });
                lightboxStage.setPointerCapture(e.pointerId);

                if (activePointers.size === 2) {
                    pinchStartDistance = pointerDistance();
                    pinchStartScale = scale;
                    panStart = null;
                    swipeStart = null;
                } else if (activePointers.size === 1) {
                    panStart = { x: e.clientX, y: e.clientY, panX: panX, panY: panY };
                    swipeStart = { x: e.clientX, y: e.clientY, time: Date.now() };
                }
            });

            lightboxStage.addEventListener('pointermove', (e) => {
                if (!activePointers.has(e.pointerId)) return;
                activePointers.set(e.pointerId, { x: e.clientX, y: e.clientY });

                if (activePointers.size === 2) {
                    const newDistance = pointerDistance();
                    if (pinchStartDistance > 0) {
                        const ratio = newDistance / pinchStartDistance;
                        scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, pinchStartScale * ratio));
                        clampPan();
                        applyTransform();
                    }
                    return;
                }

                if (activePointers.size === 1 && panStart) {
                    const dx = e.clientX - panStart.x;
                    const dy = e.clientY - panStart.y;

                    if (scale > 1) {
                        panX = panStart.panX + dx;
                        panY = panStart.panY + dy;
                        clampPan();
                        applyTransform();
                    }
                }
            });

            function endPointer(e) {
                const wasSingle = activePointers.size === 1;
                const swipeInfo = swipeStart;

                activePointers.delete(e.pointerId);
                if (lightboxStage.hasPointerCapture && lightboxStage.hasPointerCapture(e.pointerId)) {
                    lightboxStage.releasePointerCapture(e.pointerId);
                }

                if (activePointers.size < 2) {
                    pinchStartDistance = 0;
                }

                if (wasSingle && scale <= 1 && swipeInfo) {
                    const dx = e.clientX - swipeInfo.x;
                    const dy = e.clientY - swipeInfo.y;
                    const elapsed = Date.now() - swipeInfo.time;

                    if (elapsed < 600 && Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) {
                        if (dx < 0) nextPhoto(); else prevPhoto();
                    }
                }

                panStart = null;
                swipeStart = null;
            }

            lightboxStage.addEventListener('pointerup', endPointer);
            lightboxStage.addEventListener('pointercancel', endPointer);
        })();
    </script>
@endsection
