@extends('layout.frontend.main', ['activePage' => 'Review', 'titlePage' => __('Review Saya')])
@section('title', 'Review Saya')

@section('content')
<div class="container mt-4" style="margin-bottom: 10em">
    <h3 style="margin-top: 8em">Review Datasets Order #{{ $order->id }}</h3>
    <form action="{{ route('frontend-orders.submitReview', $order->id) }}" method="POST">
        @csrf
        @foreach($researchDatas as $data)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $data->research_title }}
                </div>
                <div class="card-body">
                    <textarea name="reviews[{{ $data->id }}]" rows="3" class="form-control" placeholder="Tulis ulasan Anda di sini..." required>{{ old('reviews.' . $data->id) }}</textarea>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn-sm btn-primary">Kirim Semua Review</button>
    </form>
</div>
@endsection