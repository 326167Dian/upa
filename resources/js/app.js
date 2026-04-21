import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import DataTable from 'datatables.net-bs5';

import 'datatables.net-bs5/css/dataTables.bootstrap5.css';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const ckeditorUploadUrl = document.querySelector('meta[name="ckeditor-upload-url"]')?.getAttribute('content') || '';

class LaravelUploadAdapter {
	constructor(loader) {
		this.loader = loader;
		this.abortController = new AbortController();
	}

	upload() {
		return this.loader.file.then((file) => {
			const formData = new FormData();
			formData.append('upload', file);

			return fetch(ckeditorUploadUrl, {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken,
					'X-Requested-With': 'XMLHttpRequest',
				},
				body: formData,
				signal: this.abortController.signal,
			})
				.then(async (response) => {
					const data = await response.json().catch(() => ({}));

					if (!response.ok || !data.url) {
						throw new Error(data.message || 'Upload gambar gagal.');
					}

					return {
						default: data.url,
					};
				});
		});
	}

	abort() {
		this.abortController.abort();
	}
}

function ckeditorUploadPlugin(editor) {
	if (!ckeditorUploadUrl) {
		return;
	}

	editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new LaravelUploadAdapter(loader);
}

function initializeCkeditor(element, richTextMode) {
	const enableImageUpload = richTextMode === 'ckeditor-image';
	const toolbar = [
		'heading',
		'|',
		'bold',
		'italic',
		'bulletedList',
		'numberedList',
	];

	if (enableImageUpload) {
		toolbar.push('|', 'imageUpload');
	}

	toolbar.push('|', 'undo', 'redo');

	ClassicEditor
		.create(element, {
			toolbar,
			extraPlugins: enableImageUpload ? [ckeditorUploadPlugin] : [],
		})
		.then((editor) => {
			editor.editing.view.change((writer) => {
				writer.setStyle('min-height', '180px', editor.editing.view.document.getRoot());
			});
		})
		.catch((error) => {
			console.error('CKEditor failed to initialize:', error);
		});
}

function syncRolePermissionScope(roleSelect) {
	const targetSelector = roleSelect.dataset.permissionScope;
	const permissionScope = targetSelector ? document.querySelector(targetSelector) : null;

	if (!permissionScope) {
		return;
	}

	const isCustomRole = roleSelect.value === 'custom';
	permissionScope.style.display = isCustomRole ? '' : 'none';

	if (!isCustomRole) {
		permissionScope.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
			checkbox.checked = false;
		});
	}
}

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('[data-rich-text]').forEach((element) => {
		initializeCkeditor(element, element.dataset.richText);
	});

	document.querySelectorAll('[data-role-selector="true"]').forEach((roleSelect) => {
		syncRolePermissionScope(roleSelect);
		roleSelect.addEventListener('change', () => {
			syncRolePermissionScope(roleSelect);
		});
	});

	document.querySelectorAll('[data-datatable="true"]').forEach((table) => {
		if (table.dataset.datatableInitialized === 'true') {
			return;
		}

		const tableBody = table.tBodies[0];

		if (tableBody) {
			const bodyRows = Array.from(tableBody.rows);
			const containsOnlyPlaceholderRows = bodyRows.length > 0 && bodyRows.every((row) => {
				return row.cells.length === 1 && row.cells[0].hasAttribute('colspan');
			});

			if (containsOnlyPlaceholderRows) {
				tableBody.innerHTML = '';
			}
		}

		const disableLastColumnSort = table.dataset.disableLastColumnSort === 'true';
		const lastColumnIndex = table.querySelectorAll('thead th').length - 1;
		const columnDefs = [];

		if (disableLastColumnSort && lastColumnIndex >= 0) {
			columnDefs.push({
				orderable: false,
				targets: lastColumnIndex,
			});
		}

		new DataTable(table, {
			pageLength: Number(table.dataset.pageLength || 10),
			lengthMenu: [10, 25, 50, 100],
			order: [],
			columnDefs,
			language: {
				search: 'Cari:',
				lengthMenu: 'Tampilkan _MENU_ data',
				info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
				infoEmpty: 'Belum ada data',
				zeroRecords: 'Data tidak ditemukan',
				emptyTable: 'Belum ada data',
				paginate: {
					first: 'Awal',
					last: 'Akhir',
					next: 'Berikutnya',
					previous: 'Sebelumnya',
				},
			},
		});

		table.dataset.datatableInitialized = 'true';
	});
});
