import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

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
});
