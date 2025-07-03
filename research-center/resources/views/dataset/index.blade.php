@extends('layout.backend.main', ['activePage' => 'dataset.index', 'titlePage' => __('Index Dataset')])
@section('title','Index Dataset')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">DATASET RISET</h5>
            </div>
            <div class="card-body">
                <p align="right">
                    <a href="{{route('dataset.create')}}" class="btn btn-primary"><i class="ph-plus-circle me-2"></i> Tambah Dataset</a>
                </p>
                <table class="table table-bordered" id="data-index" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Peneliti</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="datasetModal" tabindex="-1" aria-labelledby="datasetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="datasetModalLabel">Detail Dataset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="datasetModalBody">
        <div class="text-center">Memuat...</div>
      </div>
    </div>
  </div>
</div>



<script>
$(function () {
    $('#data-index').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("dataset.data-index") }}',
        columns: [
            { data: 'id', render: (data, type, row, meta) => meta.row + 1 },
            { data: 'research_title' },
            { data: 'researcher_name' },
            { data: 'research_category_name' },
            { data: 'year' },
            { data: 'price', render: data => 'Rp ' + Number(data).toLocaleString('id-ID') },
            {
                data: 'id',
                render: (data, type, row) => `
                    <button class="btn btn-sm btn-info" onclick="showDetail(${data})">View Detail</button>
                    <a href="/dataset/edit/${data}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/dataset/destroy/${data}" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">Hapus</a>`
            }
        ]
    });
});
function showDetail(id) {
    $('#datasetModal').modal('show');
    $('#datasetModalBody').html('<div class="text-center">Memuat...</div>');

    fetch(`/dataset/detail/${id}`)
        .then(res => res.ok ? res.text() : 'Gagal memuat data')
        .then(html => $('#datasetModalBody').html(html))
        .catch(() => $('#datasetModalBody').html('<div class="text-danger">Terjadi kesalahan.</div>'));
}
</script>
@endsection
