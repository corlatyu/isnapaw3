@extends('layout.master')

@section('content')

<h1>Data Mahasiswa</h1>

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('dashboard.index') }}" method="GET" class="form-inline">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
        <a href="{{ route('dashboard.create') }}" class="btn btn-primary">Tambah</a>
       </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                     <tr>
                         <th>No</th>
                         <th>Nama</th>
                         <th>NBI</th>
                         <th>Actions</th>
                 </thead>
                 <tbody>
                     @foreach ($mahasiswas as $key => $mahasiswa)
                     <tr>
                        <td>{{ $mahasiswas->firstItem()+ $key }}</td>
                        <td>{{ $mahasiswa->nama }}</td>
                         <td>{{ $mahasiswa->nbi }}</td>
                         <td>
                             <a href="{{ route('dashboard.edit', $mahasiswa->id) }}"class="btn btn-warning btn-sm">Edit</a>
                             <form action="{{ route('dashboard.destroy', $mahasiswa->id) }}" method="POST"  style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?');">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                             </form>
                         </td>
                     </tr>
                 @endforeach
                 </tbody>
             </table>
             <div>
                Showing
                {{ $mahasiswas->firstItem() }}
                to
                {{ $mahasiswas->lastItem() }}
                of
                {{ $mahasiswas->total() }}
            </div>
            <div class="d-flex justify-content-end">
                {{ $mahasiswas->links() }}
            </div>
         </div>
     </div>
 </div>

@endsection

