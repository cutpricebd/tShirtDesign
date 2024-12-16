<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Build Landing Page</title>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <script src="https://unpkg.com/grapesjs"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,300&display=swap" rel="stylesheet">

    <style>
        body,
        html {
          height: 100%;
          margin: 0;
        }
    </style>

    <script>
        let base_path = '{{url('/')}}';
    </script>
  </head>

  <body>
    <div id="gjs" style="height:0px; overflow:hidden;">
        <style>
            {!! $css !!}
        </style>

        {!! $html !!}
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.0/dist/sweetalert2.all.min.js"></script>
    <script>
        // Alert Script
        const Toast = Swal.mixin({
            toast: true,
            position: 'center-center',
            showConfirmButton: false,
            background: '#E5F3FE',
            timer: 4000
        });
        function cAlert(type, text){
            Toast.fire({
                icon: type,
                title: text
            });
        }
    </script>

    <script type="text/javascript">
        var editor = grapesjs.init({
            showOffsets: 1,
            noticeOnUnload: 0,
            container: '#gjs',
            height: '100%',
            fromElement: true,
            storageManager: { autoload: 0 },
            styleManager : {
            sectors: [{
                name: 'General',
                    open: false,
                    buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
                },{
                    name: 'Flex',
                    open: false,
                    buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self']
                },{
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
                },{
                    name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-shadow'],
                },{
                    name: 'Decorations',
                    open: false,
                    buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background'],
                },{
                    name: 'Extra',
                    open: false,
                    buildProps: ['transition', 'perspective', 'transform'],
                }
            ],
            },
        });
    </script>

    {{-- <script src="{{asset('landing/js/'. $landing->theme .'-blocks.js')}}"></script> --}}

    <script>
        editor.BlockManager.add('imageBlock', {
            label: 'Image',
            attributes: { class:'fa fa-image' },
            content: `<img src="`+ (base_path + '/assets/imgs/default-img.png') +`" class="w-full rounded mb-6 block" alt="image">`
        })
        editor.BlockManager.add('headingBlock', {
            label: 'Heading',
            attributes: { class:'fa fa-header' },
            content: `<h2 class="text-4xl text-pink-600 mb-4">Lorem Ipsum is simply dummy!!</h2>`
        })
        editor.BlockManager.add('buttonBlock', {
            label: 'Button',
            attributes: { class:'fa fa-shopping-cart' },
            content: `<button data-scroll-nav="2" type="button" class="bg-pink-600 border border-transparent rounded-md py-2 px-2 md:px-4 items-center justify-center text-base font-medium text-white hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 block md:inline-block w-full mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                </svg>
                <span>Order Now</span>
            </button>`
        })
        editor.BlockManager.add('textBlock', {
            label: 'Text',
            attributes: { class:'fa fa-pencil-square-o' },
            content: `<p>Lorem Ipsum is simply dummy</p>`
        })
        editor.BlockManager.add('youtubeEmbedBlock', {
            label: 'Youtube Embed',
            attributes: { class:'fa fa-youtube' },
            content: `<div class="aspect-w-16 aspect-h-9 rounded-lg border-2 border-pink-600 overflow-hidden">
                        <iframe src="https://www.youtube.com/embed/kC07_ckeKv0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>`
        })
    </script>

    <script type="text/javascript">
        editor.Panels.addButton('options', [{
            id: 'save-db',
            className: 'gjs-pn-btn fa fa-save',
            command: 'save-db',
            attributes: {
                title: 'Save Changes'
            }
        }]);
        editor.Panels.removeButton('options', 'export-template');

        editor.Commands.add('save-db', {
            run: function(editor, sender) {
                sender && sender.set('active', 0);
                editor.store();
                var fullHtml = editor.getHtml();
                var cssdata = editor.getCss();
                var parser = new DOMParser();
                var doc = parser.parseFromString(fullHtml, 'text/html');
                var bodyContent = doc.body.innerHTML;

                $.ajax({
                    url: "{{route('back.landingBuilders.buildSave', $landing->id)}}",
                    method: "POST",
                    data: {_token: "{{csrf_token()}}", htmldata: bodyContent, cssdata},
                    success: function(result){
                        if(result == 'true'){
                            cAlert('success', 'Successfully Saved!');
                        }else{
                            cAlert('error', 'Save Failed!');
                        }
                    },
                    error: function(){
                        cAlert('error', 'Save Failed!');
                    }
                });
            }
        });
    </script>
  </body>
</html>
