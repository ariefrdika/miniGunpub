@extends ('dashboards.index')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard Akademi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="breadcrumb-item active">Data View Administrator</li>                    
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><b>Data View Administrator</b></h3>
                    </div>
                    <!-- /.card-header -->
                    @if ($message = Session::get('Error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Ops! Terjadi kesalahan!</h5>
                        {{ $message }}
                    </div>
                    @endif

                    @if ($message = Session::get('Success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                        {{ $message }}
                    </div>
                    @endif


                    <div class="card-body">
                        <div id="button_fungsi" class="col-md-12" style="margin-bottom:20px; margin-left:-10px;">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Tambah data barang baru
                            </button>
                        </div>
                        <table id="datanya" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Stok</th>
                                    <th>Detail</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->name }}</td>
                                        <td>{{ $barang->stok }}</td>
                                        <td>{{ $barang->detail }}</td>

                                        <td class="project-actions text-center" style="width:200px;">
                                            <button id="editnya" type="button" class="btn btn-block btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modal-default2" data-name="{{$barang->name}}" data-stok="{{$barang->stok}}" data-detail="{{$barang->detail}}"
                                                data-id="{{ $barang->id }}">
                                                <i class="fa fa-fw fas fa-edit"></i> Edit
                                            </button>
                                            @if(auth()->user()->level_user==0)
                                                <a class="btn btn-block btn-danger btn-sm" onclick="return confirm('Data barang ini akan dihapus. Lanjut?')"
                                                    href="{{ route('delete_barang', $barang->id) }}">
                                                    <i class="fa fa-fw fas fa-trash-alt"></i> Hapus
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah data barang baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myform" action="{{ route('add_barang') }}" method="post"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input name="name" type="text"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                            placeholder="Masukan nama barang" value="{{Request::old('name')}}" autocomplete="off">
                        @if($errors->has('name'))
                        <p><code>{{ $errors->first('name') }}</code></p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input name="stok" type="text" class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}" id="stok"
                            placeholder="Masukan stok barang" value="{{Request::old('stok')}}" autocomplete="off"
                            onkeypress='validate(event)'>
                        @if($errors->has('stok'))
                        <p><code>{{ $errors->first('stok') }}</code></p>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail">Detail</label>                        
                        <textarea name="detail" rows="7" cols="80"
                            class="form-control {{ $errors->has('detail') ? 'is-invalid' : '' }}" autocomplete="off"
                            placeholder="Masukan detail barang">{{Request::old('detail')}}</textarea>

                        @if($errors->has('detail'))
                        <p><code>{{ $errors->first('detail') }}</code></p>
                        @endif
                    </div>                                        
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button name="simpan" type="submit" class="btn btn-primary" value="simpan" form="myform"><i class="fa fa-share"></i> Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myform2" action="{{ route('edit_barang') }}" method="post"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="name">Nama barang</label>
                        <input name="name" type="text"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="nameedit"
                            placeholder="Masukan nama barang" value="{{Request::old('name')}}" autocomplete="off">
                        @if($errors->has('name'))
                        <p><code>{{ $errors->first('name') }}</code></p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input name="stok" type="text"
                            class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}" id="stokedit"
                            placeholder="Masukan stok barang"
                            value="{{Request::old('stok')}}" autocomplete="off" onkeypress='validate(event)'>
                        @if($errors->has('stok'))
                        <p><code>{{ $errors->first('stok') }}</code></p>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail">Detail</label>                    
                        <textarea name="detail" rows="7" cols="80"
                            class="form-control {{ $errors->has('detail') ? 'is-invalid' : '' }}" autocomplete="off"
                            placeholder="Masukan detail barang"
                            id="detailedit">{{Request::old('detail')}}</textarea>

                        @if($errors->has('detail'))
                        <p><code>{{ $errors->first('detail') }}</code></p>
                        @endif
                    </div>                                        

                    <input type="hidden" name="id" id="inputId">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary" form="myform2">Simpan perubahan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $(document).on("click", "#editnya", function () {
     $('#nameedit').val($(this).data('name'));
     $('#stokedit').val($(this).data('stok'));
     $("#detailedit").text( $(this).data('detail') );     
     $('#inputId').val($(this).data('id'));
    });
</script>

@endsection