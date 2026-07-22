@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Foto Kegiatan</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="foto-form-alert" class="alert alert-danger d-none" role="alert"></div>

                <div class="mb-3">
                    <label for="id_kegiatan" class="form-label">Nama Kegiatan</label>
                    <select id="id_kegiatan" name="id_kegiatan" class="form-control">
                        <option value="">Pilih kegiatan</option>
                        @foreach ($kegiatanList as $kegiatan)
                            <option value="{{ $kegiatan->id_kegiatan }}" @selected((string) old('id_kegiatan') === (string) $kegiatan->id_kegiatan)>{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback d-block" data-error-for="id_kegiatan"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Kegiatan</label>

                    <div id="foto-dropzone" class="foto-gallery-dropzone" tabindex="0" role="button" aria-label="Area unggah foto, klik atau seret berkas ke sini">
                        <i class="feather icon-upload-cloud foto-gallery-dropzone-icon"></i>
                        <p class="mb-1">Seret &amp; lepas foto di sini, atau <span class="foto-gallery-browse">klik untuk memilih</span></p>
                        <small class="text-muted">Format JPG, PNG, atau WEBP. Maksimal 2 MB per foto.</small>
                        <input type="file" id="foto-input" accept="image/jpeg,image/png,image/webp" multiple hidden>
                    </div>

                    <div id="foto-errors" class="invalid-feedback d-block"></div>

                    <div id="foto-gallery-empty" class="text-muted small mt-2">Belum ada foto dipilih.</div>
                    <div id="foto-gallery-grid" class="foto-gallery-grid mt-3"></div>
                </div>

                <div class="mb-4">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="5" class="form-control" placeholder="Masukkan uraian teks tentang foto">{{ old('keterangan') }}</textarea>
                    <div class="invalid-feedback d-block" data-error-for="keterangan"></div>
                </div>

                <div id="foto-upload-progress" class="mb-3 d-none">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Mengunggah foto...</span>
                        <span id="foto-upload-progress-text">0%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div id="foto-upload-progress-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('foto-kegiatan.index') }}" class="btn btn-light border">Batal</a>
                    <button type="button" id="foto-submit-btn" class="btn btn-primary">Simpan Foto</button>
                </div>
            </div>
        </div>
    </div>

    <div id="foto-lightbox" class="foto-lightbox" hidden>
        <div class="foto-lightbox-topbar">
            <div class="foto-lightbox-counter"><span id="foto-lightbox-current">1</span> / <span id="foto-lightbox-total">1</span></div>
            <button type="button" class="foto-lightbox-close" aria-label="Tutup pratinjau">&times;</button>
        </div>
        <button type="button" class="foto-lightbox-nav foto-lightbox-prev" aria-label="Foto sebelumnya">&#10094;</button>
        <div class="foto-lightbox-stage" id="foto-lightbox-stage">
            <img id="foto-lightbox-img" src="" alt="Pratinjau foto kegiatan" draggable="false">
        </div>
        <button type="button" class="foto-lightbox-nav foto-lightbox-next" aria-label="Foto berikutnya">&#10095;</button>
    </div>

    <style>
        .foto-gallery-dropzone {
            border: 2px dashed #c8d3dd;
            border-radius: 10px;
            padding: 32px 16px;
            text-align: center;
            cursor: pointer;
            background: #f8fafc;
            transition: border-color .15s ease, background-color .15s ease;
        }

        .foto-gallery-dropzone:hover,
        .foto-gallery-dropzone:focus-visible,
        .foto-gallery-dropzone.is-dragover {
            border-color: #4a7dff;
            background: #eef3ff;
            outline: none;
        }

        .foto-gallery-dropzone-icon {
            font-size: 28px;
            display: block;
            margin-bottom: 8px;
            color: #7c8a9a;
        }

        .foto-gallery-browse {
            color: #4a7dff;
            font-weight: 600;
        }

        .foto-gallery-grid {
            columns: 4 160px;
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

        .foto-gallery-item-remove {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: none;
            background: rgba(20, 20, 20, .65);
            color: #fff;
            line-height: 1;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .foto-gallery-item-remove:hover {
            background: #d9364f;
        }

        .foto-gallery-item-name {
            font-size: 11px;
            color: #6c7683;
            padding: 4px 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: #fff;
        }

        .foto-lightbox-counter {
            font-size: 14px;
            opacity: .85;
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
    </style>

    <script>
        (function () {
            'use strict';

            const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
            const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB
            const STORE_URL = @json(route('foto-kegiatan.store'));
            const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

            let photos = []; // { id, file, url }
            let nextId = 1;

            const dropzone = document.getElementById('foto-dropzone');
            const fileInput = document.getElementById('foto-input');
            const galleryGrid = document.getElementById('foto-gallery-grid');
            const galleryEmpty = document.getElementById('foto-gallery-empty');
            const fotoErrors = document.getElementById('foto-errors');
            const formAlert = document.getElementById('foto-form-alert');
            const submitBtn = document.getElementById('foto-submit-btn');
            const progressWrap = document.getElementById('foto-upload-progress');
            const progressBar = document.getElementById('foto-upload-progress-bar');
            const progressText = document.getElementById('foto-upload-progress-text');

            // ---------- File selection & validation ----------

            function humanSize(bytes) {
                return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
            }

            function addFiles(fileList) {
                const rejected = [];

                Array.from(fileList).forEach((file) => {
                    if (!ALLOWED_TYPES.includes(file.type)) {
                        rejected.push(file.name + ' — tipe berkas tidak didukung (hanya JPG, PNG, WEBP).');
                        return;
                    }

                    if (file.size > MAX_FILE_SIZE) {
                        rejected.push(file.name + ' — ukuran ' + humanSize(file.size) + ' melebihi batas 2 MB.');
                        return;
                    }

                    photos.push({
                        id: nextId++,
                        file: file,
                        url: URL.createObjectURL(file),
                    });
                });

                if (rejected.length) {
                    fotoErrors.innerHTML = rejected.map((msg) => '<div>' + msg + '</div>').join('');
                } else {
                    fotoErrors.innerHTML = '';
                }

                renderGallery();
            }

            function removePhoto(id) {
                const index = photos.findIndex((p) => p.id === id);
                if (index === -1) return;

                URL.revokeObjectURL(photos[index].url);
                photos.splice(index, 1);
                renderGallery();
            }

            function renderGallery() {
                galleryGrid.innerHTML = '';
                galleryEmpty.classList.toggle('d-none', photos.length > 0);

                photos.forEach((photo, index) => {
                    const item = document.createElement('div');
                    item.className = 'foto-gallery-item';

                    const img = document.createElement('img');
                    img.src = photo.url;
                    img.alt = photo.file.name;
                    img.addEventListener('click', () => openLightbox(index));

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'foto-gallery-item-remove';
                    removeBtn.setAttribute('aria-label', 'Hapus foto');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        removePhoto(photo.id);
                    });

                    const name = document.createElement('div');
                    name.className = 'foto-gallery-item-name';
                    name.textContent = photo.file.name;

                    item.appendChild(img);
                    item.appendChild(removeBtn);
                    item.appendChild(name);
                    galleryGrid.appendChild(item);
                });
            }

            dropzone.addEventListener('click', () => fileInput.click());
            dropzone.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    fileInput.click();
                }
            });

            fileInput.addEventListener('change', () => {
                addFiles(fileInput.files);
                fileInput.value = '';
            });

            ['dragenter', 'dragover'].forEach((evt) => {
                dropzone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('is-dragover');
                });
            });

            ['dragleave', 'drop'].forEach((evt) => {
                dropzone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('is-dragover');
                });
            });

            dropzone.addEventListener('drop', (e) => {
                if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
                    addFiles(e.dataTransfer.files);
                }
            });

            // ---------- Lightbox ----------

            const lightbox = document.getElementById('foto-lightbox');
            const lightboxStage = document.getElementById('foto-lightbox-stage');
            const lightboxImg = document.getElementById('foto-lightbox-img');
            const lightboxCurrent = document.getElementById('foto-lightbox-current');
            const lightboxTotal = document.getElementById('foto-lightbox-total');
            const closeBtn = lightbox.querySelector('.foto-lightbox-close');
            const prevBtn = lightbox.querySelector('.foto-lightbox-prev');
            const nextBtn = lightbox.querySelector('.foto-lightbox-next');

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

            function openLightbox(index) {
                if (!photos.length) return;
                currentIndex = index;
                resetTransform();
                lightboxImg.src = photos[currentIndex].url;
                lightboxCurrent.textContent = currentIndex + 1;
                lightboxTotal.textContent = photos.length;
                lightbox.hidden = false;
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.hidden = true;
                document.body.style.overflow = '';
            }

            function showPhoto(index) {
                if (!photos.length) return;
                currentIndex = (index + photos.length) % photos.length;
                resetTransform();
                lightboxImg.src = photos[currentIndex].url;
                lightboxCurrent.textContent = currentIndex + 1;
            }

            function nextPhoto() { showPhoto(currentIndex + 1); }
            function prevPhoto() { showPhoto(currentIndex - 1); }

            closeBtn.addEventListener('click', closeLightbox);
            nextBtn.addEventListener('click', nextPhoto);
            prevBtn.addEventListener('click', prevPhoto);

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            document.addEventListener('keydown', (e) => {
                if (lightbox.hidden) return;
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowRight') nextPhoto();
                if (e.key === 'ArrowLeft') prevPhoto();
            });

            // Desktop wheel zoom (ctrl + scroll)
            lightboxStage.addEventListener('wheel', (e) => {
                if (!e.ctrlKey) return;
                e.preventDefault();

                const delta = -e.deltaY * 0.01;
                const newScale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, scale + delta));

                scale = newScale;
                clampPan();
                applyTransform();
            }, { passive: false });

            // Pointer Events: pinch-to-zoom, pan, and swipe navigation
            const activePointers = new Map();
            let pinchStartDistance = 0;
            let pinchStartScale = 1;
            let panStart = null; // { x, y, panX, panY }
            let swipeStart = null; // { x, y, time }

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

            // ---------- Field-level error display ----------

            function clearErrors() {
                formAlert.classList.add('d-none');
                formAlert.innerHTML = '';
                document.querySelectorAll('[data-error-for]').forEach((el) => {
                    el.textContent = '';
                });
                fotoErrors.innerHTML = '';
            }

            function showErrors(errors) {
                Object.keys(errors).forEach((key) => {
                    const messages = errors[key];

                    if (key === 'id_kegiatan' || key === 'keterangan') {
                        const target = document.querySelector('[data-error-for="' + key + '"]');
                        if (target) target.textContent = messages[0];
                        return;
                    }

                    if (key.startsWith('foto')) {
                        const div = document.createElement('div');
                        div.textContent = messages[0];
                        fotoErrors.appendChild(div);
                        return;
                    }

                    formAlert.classList.remove('d-none');
                    formAlert.innerHTML += '<div>' + messages[0] + '</div>';
                });
            }

            // ---------- Submit with progress ----------

            function setUploading(isUploading) {
                submitBtn.disabled = isUploading;
                dropzone.classList.toggle('d-none', isUploading);
                progressWrap.classList.toggle('d-none', !isUploading);

                if (!isUploading) {
                    progressBar.style.width = '0%';
                    progressText.textContent = '0%';
                }
            }

            submitBtn.addEventListener('click', () => {
                clearErrors();

                const idKegiatan = document.getElementById('id_kegiatan').value;
                const keterangan = document.getElementById('keterangan').value.trim();
                let hasError = false;

                if (!idKegiatan) {
                    document.querySelector('[data-error-for="id_kegiatan"]').textContent = 'Kegiatan wajib dipilih.';
                    hasError = true;
                }

                if (!photos.length) {
                    fotoErrors.textContent = 'Pilih minimal satu foto untuk diunggah.';
                    hasError = true;
                }

                if (!keterangan) {
                    document.querySelector('[data-error-for="keterangan"]').textContent = 'Keterangan wajib diisi.';
                    hasError = true;
                }

                if (hasError) return;

                const formData = new FormData();
                formData.append('id_kegiatan', idKegiatan);
                formData.append('keterangan', keterangan);
                photos.forEach((photo) => formData.append('foto[]', photo.file, photo.file.name));

                const xhr = new XMLHttpRequest();
                xhr.open('POST', STORE_URL, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', CSRF_TOKEN);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.addEventListener('progress', (e) => {
                    if (!e.lengthComputable) return;
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressText.textContent = percent + '%';
                });

                xhr.addEventListener('load', () => {
                    let response = {};
                    try { response = JSON.parse(xhr.responseText); } catch (err) { /* noop */ }

                    if (xhr.status >= 200 && xhr.status < 300) {
                        progressBar.style.width = '100%';
                        progressText.textContent = '100%';
                        window.location.href = response.redirect || STORE_URL;
                        return;
                    }

                    setUploading(false);

                    if (xhr.status === 422 && response.errors) {
                        showErrors(response.errors);
                    } else {
                        formAlert.classList.remove('d-none');
                        formAlert.textContent = response.message || 'Terjadi kesalahan saat mengunggah foto.';
                    }
                });

                xhr.addEventListener('error', () => {
                    setUploading(false);
                    formAlert.classList.remove('d-none');
                    formAlert.textContent = 'Gagal terhubung ke server. Silakan coba lagi.';
                });

                setUploading(true);
                xhr.send(formData);
            });
        })();
    </script>
@endsection
