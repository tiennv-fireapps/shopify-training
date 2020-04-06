@include('layouts.header')
<body class="bg-light d-flex flex-row justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-5">
                    SHOP : {{ $shop->shop }}
                </h1>
            </div>
            @foreach($products as $product)
                @php
                    $product['image']['src'] = empty($product['image']['src']) ? '/images/2.png': $product['image']['src'];
                @endphp
                <div class="col-3">
                    <div class="card" style="">
                        <img class="card-img-top" src="{{$product['image']['src']}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product['title'] }}</h5>
                            <p class="card-text">{{ $product['body_html'] }}</p>
                            <a href="/product/{{ $product['id'] }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
@include('layouts.footer')
