@extends('layout.master')

@section('content')
<h1>Data Ticket</h1>

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="card-header py-3">
     </div>
     <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('ticket.index') }}" method="GET" class="form-inline">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
        <a href="{{ route('ticket.create') }}" class="btn btn-primary">Tambah</a>
       </div>
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th>No</th>
                         <th>Nama Wisata</th>
                         <th>Harga Ticket</th>
                         <th>Gambar</th>
                         <th>Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($tickets as $key => $ticket)
                     <tr>
                        <td>{{ $tickets->firstItem()+ $key }}</td>
                         <td>{{ $ticket->nama_ticket }}</td>
                         <td>{{ $ticket->harga_ticket }}</td>
                         <td><img src="{{ asset($ticket->gambar) }}" width="100"></td>
                         <td>
                             <a href="{{ route('ticket.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>
                             <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?');">
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
                {{ $tickets->firstItem() }}
                to
                {{ $tickets->lastItem() }}
                of
                {{ $tickets->total() }}
            </div>
            <div class="d-flex justify-content-end">
                {{ $tickets->links() }}
            </div>
         </div>
     </div>
 </div>
@endsection
