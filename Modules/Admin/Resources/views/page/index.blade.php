@extends('admin::layouts.master')
@section('page_title', env('APP_NAME') . ' | Pages')
@section('body_class', 'hold-transition skin-blue sidebar-mini')
@section('styles')
  <link href="{{url('media/fine-uploader/fine-uploader-gallery.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ url('media/plugins/iCheck/square/blue.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
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
    </div>
  </script>

@endsection

@section('body')
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
        Pages
        @if( Helper::hasAccess('module.admin.page.create') )
        <a class="btn btn-success btn-header" href="{{ url('admin/page/create') }}">Create page</a>
        @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Page</li>
      </ol>
    </section>

    
    <section class="content">
      
      {!!session()->has('success') ? '<div class="callout callout-success"><h4><i class="icon fa fa-check"></i> Success</h4><p>'. session()->get('success') .'</p></div>' : ''!!}

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pages</h3>

              <div class="box-tools">
                <form method="get" action="{{ url('admin/pages') }}">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="s" class="form-control pull-right" placeholder="Search" value="{{ request('s') }}" />

                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th width="40">ID</th>
                  <th>Title</th>
                  <th width="180">Date Created</th>
                  <th width="100">Status</th>
                  <th colspan="2">Action</th>
                </tr>
                @forelse($pages as $page)
                <tr>
                  <td>{{ $page->id }}</td>
                  <td>{!! ( $page->parent_id != 0 ? '&mdash; ' : '' ) . $page->title !!}</td>
                  <td>{{ $page->created_at->diffForHumans() }}</td>
                  <td>
                    @if( $page->status )
                    <span class="label label-success">Published</span></td>
                    @else
                    <span class="label label-warning">Draft</span></td>
                    @endif
                  <td width="30"><a data-toggle="tooltip" title="Edit" href="{{ url('admin/page/' . $page->id . '/update') }}"><i class="fa fa-edit"></i></a></td>
                  <td width="30"><a data-toggle="tooltip" title="Delete" data-href="{{ url('admin/page/' . $page->id . '/delete') }}" data-delete-item="" href="#"><i class="fa fa-trash"></i></a></td>
                </tr>
                @empty
                <tr>
                  <td colspan="6"><a href="{{ url('admin/page/create') }}">Create a page here</a></td>
                </tr>
                @endforelse
              </table>
            </div>
            <!-- /.box-body -->

            <div class="box-footer clearfix text-center">
              {{ $pagination->links() }}
            </div>
            <!-- /.box-footer -->

          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    
  </div>

<!-- ./wrapper -->
@endsection
