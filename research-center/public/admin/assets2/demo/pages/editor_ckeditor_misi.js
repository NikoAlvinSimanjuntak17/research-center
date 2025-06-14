// misi.js

const CKEditorMisi = function () {
    const _componentCKEditorMisi = function () {
        if (typeof DecoupledEditor === 'undefined') {
            console.warn('Warning - DecoupledEditor is not loaded.');
            return;
        }

        DecoupledEditor.create(document.querySelector('#document_editor_misi .document-editor-editable'), {
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
        })
        .then(editor => {
            window.editorMisi = editor;
            const toolbarContainer = document.querySelector('#document_editor_misi .document-editor-toolbar');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);

            const form = document.getElementById('visimisi-form');
            const hiddenInput = document.getElementById('misi-hidden');

            if (form && hiddenInput) {
                form.addEventListener('submit', function () {
                    hiddenInput.value = editor.getData();
                });
            }
        })
        .catch(error => {
            console.error(error);
        });
    };

    return {
        init: function () {
            _componentCKEditorMisi();
        }
    };
}();

document.addEventListener('DOMContentLoaded', function () {
    CKEditorMisi.init();
});
