@extends('layouts.layouts')
@section('css')
<style>



.signature-pad {
    border: 1px solid #ccc;
    width: 100%;
    height: 200px;
    touch-action: none; /* Prevents default touch behavior */
}

/* Responsive layout for small screens */
@media (max-width: 768px) {
    #fb-editor, #form-preview {
    width: 100%;
    }

    button {
    width: 100%;
    padding: 10px;
    }

    .signature-pad {
    height: 150px;
    }
}
</style>
@endsection

@section('content')
<div id="fb-editor"></div>
<button id="preview-btn">Preview</button>
<div id="form-preview"></div>

@endsection
@section('script')

<script>
    let formBuilder = $(document.getElementById('fb-editor')).formBuilder({
    fields: [
    {
        label: 'Signature',
        attrs: {
        type: 'signature'
        },
        icon: '✍️'
    }],
    templates: {

        signature: function(fieldData) {
        return {
            field: `<canvas id="${fieldData.name}" class="signature-pad"></canvas><button type="button" id="clear-${fieldData.name}">Clear</button>`,
            onRender: function() {
            const canvas = document.getElementById(fieldData.name);
            const signaturePad = new SignaturePad(canvas);
            resizeCanvas(canvas); // Resize canvas to avoid drawing issues

            document.getElementById(`clear-${fieldData.name}`).addEventListener('click', function() {
                signaturePad.clear();
            });

            window.addEventListener('resize', () => resizeCanvas(canvas)); // Resize canvas on window resize
            }
        };
        }
    }
    });

    function resizeCanvas(canvas) {
    const context = canvas.getContext('2d');
    // Adjust the canvas size to match the CSS size
    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientHeight;
    // Reset the drawing context
    context.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Button Preview
    document.getElementById('preview-btn').addEventListener('click', function() {
    const formData = formBuilder.actions.getData(); // Get form data
    $('#form-preview').formRender({
        formData: formData,
        templates: {
        starRating: function(fieldData) {
            return {
            field: '<span id="'+fieldData.name+'">',
            onRender: function() {
                $(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
            }
            };
        },
        signature: function(fieldData) {
            return {
            field: `<canvas id="${fieldData.name}" class="signature-pad"></canvas><button type="button" id="clear-${fieldData.name}">Clear</button>`,
            onRender: function() {
                const canvas = document.getElementById(fieldData.name);
                const signaturePad = new SignaturePad(canvas);
                resizeCanvas(canvas);

                document.getElementById(`clear-${fieldData.name}`).addEventListener('click', function() {
                signaturePad.clear();
                });

                window.addEventListener('resize', () => resizeCanvas(canvas));
            }
            };
        }
        }
    });
    });
</script>
@endsection



