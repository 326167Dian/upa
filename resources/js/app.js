import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import DataTable from 'datatables.net-bs5';

import 'datatables.net-bs5/css/dataTables.bootstrap5.css';

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('[data-rich-text="ckeditor"]').forEach((element) => {
		ClassicEditor
			.create(element, {
				toolbar: [
					'heading',
					'|',
					'bold',
					'italic',
					'bulletedList',
					'numberedList',
					'|',
					'undo',
					'redo',
				],
			})
			.then((editor) => {
				editor.editing.view.change((writer) => {
					writer.setStyle('min-height', '180px', editor.editing.view.document.getRoot());
				});
			})
			.catch((error) => {
				console.error('CKEditor failed to initialize:', error);
			});
	});

	document.querySelectorAll('[data-datatable="true"]').forEach((table) => {
		if (table.dataset.datatableInitialized === 'true') {
			return;
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
