<table class="table table-bordered">
    <tr>
        <th>Judul</th>
        <td>{{ $data->research_title }}</td>
    </tr>
    <tr>
        <th>Peneliti</th>
        <td>{{ $data->researcher_name }}</td>
    </tr>
    <tr>
        <th>Kategori</th>
        <td>{{ $data->research_category_name }}</td>
    </tr>
    <tr>
        <th>Tahun</th>
        <td>{{ $data->year }}</td>
    </tr>
    <tr>
        <th>Harga</th>
        <td>{{ $data->price == 0 ? 'Gratis' : 'Rp ' . number_format($data->price, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td>{{ $data->abstract }}</td>
    </tr>
    <tr>
        <th>File Dataset</th>
        <td>
            @if(is_array($data->file_path))
                <ul>
                @foreach($data->file_path as $file)
                    <li>
                        <a href="{{ route('dataset.download.direct', $data->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                    </li> <br>
                @endforeach
                </ul>
            @else
                <em>Tidak ada file</em>
            @endif
        </td>
    </tr>
</table>
