document.addEventListener('DOMContentLoaded', function () {
    if (typeof DecoupledEditor === 'undefined') {
        console.warn('CKEditor DecoupledEditor tidak ditemukan.');
        return;
    }

    const editorElement = document.querySelector('#editor');
    const toolbarContainer = document.querySelector('#toolbar-container');
    const form = document.querySelector('form');
    const hiddenInput = document.getElementById('content');

    if (!editorElement || !toolbarContainer || !form || !hiddenInput) {
        console.warn('Elemen CKEditor tidak lengkap.');
        return;
    }

    DecoupledEditor.create(editorElement, {
        placeholder: 'Tulis isi berita di sini...',
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        }
    }).then(editor => {
        window.editor = editor;
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);

        form.addEventListener('submit', function (e) {
            const data = editor.getData().trim();
            if (!data) {
                e.preventDefault();
                alert('Isi berita tidak boleh kosong.');
                return;
            }
            hiddenInput.value = data;
        });

        // Optional: load old content (only needed in create/edit)
        const oldContent = hiddenInput.dataset.oldContent;
        if (oldContent) editor.setData(oldContent);
    }).catch(error => {
        console.error('CKEditor initialization error:', error);
    });
});
