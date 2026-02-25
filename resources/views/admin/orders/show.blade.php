@extends('layouts.admin')

@section('title', 'Commande ' . $order->number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Commande {{ $order->number }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">Retour</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white">Articles</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Produit</th><th>Qté</th><th>Prix</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }} @if($item->variant_label)<br><small class="text-muted">{{ $item->variant_label }}</small>@endif</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ number_format($item->price, 2) }} €</td>
                            <td>{{ number_format($item->total, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between"><span>Sous-total</span><span>{{ number_format($order->subtotal, 2) }} €</span></div>
                @if($order->discount_amount > 0)<div class="d-flex justify-content-between text-success"><span>Réduction ({{ $order->coupon_code }})</span><span>-{{ number_format($order->discount_amount, 2) }} €</span></div>@endif
                <div class="d-flex justify-content-between"><span>Livraison</span><span>{{ number_format($order->delivery_price, 2) }} €</span></div>
                <div class="d-flex justify-content-between fw-bold mt-2"><span>Total</span><span>{{ number_format($order->total, 2) }} €</span></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white">Adresse de livraison</div>
            <div class="card-body">
                <p class="mb-0">{{ $order->shipping_name }}<br>{{ $order->shipping_address }}<br>{{ $order->shipping_postal_code }} {{ $order->shipping_city }}<br>{{ $order->shipping_country }}<br>Tél. {{ $order->customer_phone }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">Statut</div>
            <div class="card-body">
                <p class="mb-2">Statut actuel : <span class="badge bg-{{ $order->status === 'paid' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">{{ $order->status }}</span></p>
                @if($order->invoice_number)<p class="small mb-0">Facture : {{ $order->invoice_number }}</p>@endif
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="status_radio" id="st_pending" value="pending" {{ $order->status === 'pending' ? 'checked' : '' }}>
                        <label class="btn btn-outline-warning btn-sm" for="st_pending">En attente</label>
                        <input type="radio" class="btn-check" name="status_radio" id="st_paid" value="paid" {{ $order->status === 'paid' ? 'checked' : '' }}>
                        <label class="btn btn-outline-success btn-sm" for="st_paid">Payé</label>
                        <input type="radio" class="btn-check" name="status_radio" id="st_shipped" value="shipped" {{ $order->status === 'shipped' ? 'checked' : '' }}>
                        <label class="btn btn-outline-info btn-sm" for="st_shipped">Expédié</label>
                        <input type="radio" class="btn-check" name="status_radio" id="st_delivered" value="delivered" {{ $order->status === 'delivered' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary btn-sm" for="st_delivered">Livré</label>
                    </div>
                    <input type="hidden" name="status" id="status_input" value="{{ $order->status }}">
                    <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('input[name="status_radio"]').forEach(function(r) {
    r.addEventListener('change', function() { document.getElementById('status_input').value = this.value; });
});
</script>
@endpush
@endsection
