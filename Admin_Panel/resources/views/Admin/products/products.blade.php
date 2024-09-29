@extends('Admin.layouts.parent')
@section('title', 'products')
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
                <th>price</th>
                <th>quantity</th>
                <th>status</th>
                <th>created at</th>
                <th>sub-categories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name_en}}</td>
                <td>{{$product->name_ar}}</td>
                <td> {{$product->price}}</td>
                <td>{{$product->quantity}}</td>
                <td class={{$product->status == 0 ? 'text-danger' : 'text-success'}}>{{$product->status == 0 ? 'Not Active' : 'Active'}}</td>
                <td>{{$product->created_at}}</td>
                @php
                // dd($sub_categories);
                    $x=0;
                @endphp
                @foreach ($sub_categories as $sub)
                    @if ($sub->id == $product->subcate_id)
                        <td>{{$sub->name_en}}</td>
                        @php
                            $x=1;
                        @endphp
                    @endif
                    @endforeach
                    @if (!$x)
                        <td class="text-danger">Not Active</td>
                    @endif
                <td>
                  <a href="{{route('products.edit',$product->id)}}" class="btn btn-warning">Edit</a>
                  <form action="{{route('products.delete',$product->id)}}" method="post" class="d-inline">
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
