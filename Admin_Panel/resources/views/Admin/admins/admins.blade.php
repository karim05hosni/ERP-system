@extends('Admin.layouts.parent')
@section('title', 'Admins')
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

    <a href="{{route('admins.create')}}" class="btn btn-warning">Create</a>
    <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>{{$admin->name}}</td>
                <td>{{$admin->role}}</td>
                {{-- <td> {{$admin->Permissions}}</td> --}}
                <td>
                    {{-- @dd($admin->Permissions) --}}
                    @foreach ($admin->permissions as $permission)
                        {{$permission->name}}
                        <br>
                    @endforeach
                </td>
                <td>
                <a href="{{route('admins.edit',$admin->id)}}" class="btn btn-warning">Edit</a>
                <form action="{{route('admins.delete',$admin->id)}}" method="post" class="d-inline">
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
