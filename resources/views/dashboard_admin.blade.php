@extends('layout.main')
@section('title', 'GuruCoding | Dashboard')
@section('keywords', 'Sistem Pengelolaan GuruCoding, GuruCoding, Sistem Pengelolaan, Website, gurucoding, admin')
@section('description', 'Dashboard Admin GuruCoding')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h2>List Mentor</h2>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Handphone</th>
                                <th>Keterampilan</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mentors as $mentor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mentor->name }}</td>
                                    <td>{{ $mentor->user->email }}</td>
                                    <td>{{ $mentor->phone }}</td>
                                    <td>{{ $mentor->skills }}</td>
                                    <td>{{ substr($mentor->alamat, 0, 50) }}...</td>
                                    <td>
                                        <a href="{{ route('detailMentor', encrypt($mentor->id)) }}" class="btn btn-info btn-sm">Detail</a>
                                        <form action="{{ route('destroyMentor',encrypt($mentor->id)) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mentor ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
