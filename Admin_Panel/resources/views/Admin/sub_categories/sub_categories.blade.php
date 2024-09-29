@extends('Admin.layouts.parent')
@section('title', 'Sub-Categories')
@section('css')
<!-- DataTables -->
  <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
    {{-- {{$success}} --}}
    @php
        
        $success = session()->get('success');
    @endphp

    @if (isset($success))
        @if ($success)
          <div class="alert alert-success fade">
            Updated Successfuly !
          </div>
        @else
          <div class="alert alert-danger fade">
            Updated Fail !
          </div>
        @endif
        <style>
          .fade {
            animation: fadeOut 3.4s forwards;
          }
        
          @keyframes fadeOut {
            0% {
              opacity: 1;
            }
            50% {
              opacity: 0.7;
            }
            100% {
              opacity: 0;
              visibility: hidden;
            }
          }
        </style>
        <script>
          const alertDiv = document.querySelector('.fade');
          alertDiv.addEventListener('animationend', () => {
            alertDiv.remove();
          });
        </script>
    @endif

    @php
        $del = session()->get('del');
    @endphp

    @if (isset($del))
        @if ($del)
          <div class="alert alert-success fade">
            Deleted Successfuly !
          </div>
        @else
          <div class="alert alert-danger fade">
            Delete Failed !
          </div>
        @endif
        <style>
          .fade {
            animation: fadeOut 5s forwards;
          }
        
          @keyframes fadeOut {
            0% {
              opacity: 1;
            }
            50% {
              opacity: 0.7;
            }
            100% {
              opacity: 0;
              visibility: hidden;
            }
          }
        </style>
        <script>
          const alertDiv = document.querySelector('.fade');
          alertDiv.addEventListener('animationend', () => {
            alertDiv.remove();
          });
        </script>
    @endif
    <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>name en</th>
                <th>name ar</th>
                <th>status</th>
                <th>created at</th>
                <th>categories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sub_categories as $sub_category)
            <tr>
                <td>{{$sub_category->id}}</td>
                <td>{{$sub_category->name_en}}</td>
                <td>{{$sub_category->name_ar}}</td>
                <td class={{$sub_category->status == 0 ? 'text-danger' : 'text-success'}}>{{$sub_category->status == 0 ? 'Not Active' : 'Active'}}</td>
                <td>{{$sub_category->created_at}}</td>
                @foreach ($categories as $cate)
                    @if ($cate->id == $sub_category->category_id)
                        <td>{{$cate->name_en}}</td>
                    @endif
                @endforeach
                <td>
                  <a href="{{route('sub_categories.edit',$sub_category->id)}}" class="btn btn-warning">Edit</a>
                  <form action="{{route('sub_categories.delete',$sub_category->id)}}" method="post" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">
                      Delete
                    </button>
                  </form>
                </td>
            </tr>
            @endforeach
        </tbody> 
        
    </table>
@endsection
@section('scripts')
<script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endsection
