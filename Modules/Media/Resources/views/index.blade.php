@extends('admin::layouts.master')
@section('page_title', env('APP_NAME') . ' | Media Library')
@section('body_class', 'hold-transition skin-blue sidebar-mini')
@section('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link href="{{url('media/fine-uploader/fine-uploader-gallery.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ url('media/plugins/iCheck/square/blue.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
  <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
  <script src="{{url('media/plugins/iCheck/icheck.min.js')}}"></script>
  <script src="{{url('media/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{url('media/fine-uploader/fine-uploader.min.js')}}"></script>
  <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
  </script>

  <script>
    $(function () {

      // Step 1: Create reusable jQuery plugin
      // =====================================

      $.fancyConfirm = function (opts) {
        opts = $.extend(true, {
          title: 'Are you sure?',
          message: '',
          okButton: 'OK',
          noButton: 'Cancel',
          callback: $.noop
        }, opts || {});

        $.fancybox.open({
          type: 'html',
          src: '<div class="fc-content p-5 rounded">' +
            '<h2 class="mb-3">' + opts.title + '</h2>' +
            '<p>' + opts.message + '</p>' +
            '<p class="text-right">' +
            '<a data-value="0" data-fancybox-close href="javascript:;" class="btn btn-default">' + opts.noButton + '</a> &nbsp;' +
            '<button data-value="1" data-fancybox-close class="btn btn-warning">' + opts.okButton + '</button>' +
            '</p>' +
            '</div>',
          opts: {
            animationDuration: 350,
            animationEffect: 'material',
            modal: true,
            baseTpl: '<div class="fancybox-container fc-container" role="dialog" tabindex="-1">' +
              '<div class="fancybox-bg"></div>' +
              '<div class="fancybox-inner">' +
              '<div class="fancybox-stage"></div>' +
              '</div>' +
              '</div>',
            afterClose: function (instance, current, e) {
              var button = e ? e.target || e.currentTarget : null;
              var value = button ? $(button).data('value') : 0;

              opts.callback(value);
            }
          }
        });
      }



      var uploader = new qq.FineUploader({
        element: document.getElementById("uploader"),
        debug: true,
        request: {
          endpoint: '{{ url('/admin/media/uploads') }}',
          customHeaders: {
            "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
          }
        },
        callbacks: {
          onComplete: function(id, name, response) {
            console.log(response);
            this.setName(id, response.info.file_name);
          },
          onAllComplete: function(){
            $.get('{{url('admin/media/files')}}',function(response){
              $('.media-library').animate({
                'opacity':0
              },function(){
                $(this).empty();
                $(response).find('.media-library-boxes').appendTo('.media-library');
                $(this).animate({
                  'opacity':1
                });
              });
              
            });
          }
        }
      });



      $(document).on('click','.media-library-delete',function(e){
        e.preventDefault();

        var src = $(this).data('src');

        $.fancyConfirm({
          title: "Please confirm delete",
          message: "Are you sure you want to delete this file?",
          okButton: 'Yes',
          noButton: 'Cancel',
          callback: function (value) {
            if (value) {

              $.post(src,{
                '_token' : $('meta[name="csrf-token"]').attr('content')
              },function(response){

                $.get('{{url('admin/media/files')}}',function(response){
                  $('.media-library').animate({
                    'opacity':0
                  },function(){
                    $(this).empty();
                    $(response).find('.media-library-boxes').appendTo('.media-library');
                    $(this).animate({
                      'opacity':1
                    });
                  });
                  
                });

                $.fancybox.open({
                  src  : '#animatedModal',
                  type : 'inline',
                  opts : {
                    afterShow : function( instance, current ) {
                      console.info( 'done!' );
                    }
                  }
                });
              });

            } else {
              $("#test_confirm_rez").html("Maybe later.");
            }
          }
        }); 
      });      
    });
  </script>
@endsection

@section('body')

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        Media Library
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Media Library</li>
      </ol>
    </section>



    <section class="content">
      <div id="uploader"></div>

      <div class="box media-library-container">
        <div class="box-header">
          <h3 class="box-title">Filter</h3>

          <select class="form-control" style="display:inline-block; width:auto; margin-left:15px; min-width:180px">
            <option value="">All</option>
            <option value="">Image</option>
            <option value="">PDF</option>
            <option value="">Video</option>
          </select>

        </div>
        <div class="box-body">
          <div class="media-library">

            @forelse( $files as $file )
            <div class="media-library-boxes">
              <a data-src="{{ url('admin/media/file/' .$file->id . '/delete') }}" href="#" class="media-library-delete media-library-close"  data-toggle="tooltip" title="Delete"><i class="fa fa-close"></i></a>
              <a data-fancybox data-type="ajax" data-modal="true" data-src="{{ url('admin/media/file/' . $file->id) }}" href="javascript:;" class="media-library-info"  data-toggle="tooltip" title="Details"><i class="fa fa-search"></i></a>
              <img src="{{$file->thumbnail}}" />
              <div class="media-library-description">
                {{$file->name}}
              </div>
            </div><!-- .media-library-boxes -->
            @empty
            <p class="text-center">No files uploaded at the moment.</p>
            @endforelse
          </div>
        </div>
      </div>

    </section>


  </div>

  <div style="display: none;" id="animatedModal" class="animated-modal text-center p-5">
      <h2>Success!</h2>
      <p>File successfully deleted.<br /></p>
      <p class="mb-0">
          <svg width="150" height="150" viewBox="0 0 510 510" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <path fill="#fff" d="M150.45,206.55l-35.7,35.7L229.5,357l255-255l-35.7-35.7L229.5,285.6L150.45,206.55z M459,255c0,112.2-91.8,204-204,204 S51,367.2,51,255S142.8,51,255,51c20.4,0,38.25,2.55,56.1,7.65l40.801-40.8C321.3,7.65,288.15,0,255,0C114.75,0,0,114.75,0,255 s114.75,255,255,255s255-114.75,255-255H459z"></path>
          </svg>
      </p>
  </div>



@endsection

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('media.name') !!}
    </p>
@endsection
