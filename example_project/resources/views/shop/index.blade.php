@include('layouts.header')
<body class="bg-light d-flex flex-row justify-content-center align-items-center vh-100">
<form class="w-50 bg-white py-4 px-4" method="post" action="/auth">
    @csrf
    <div class="form-group ">
        <h1 class="text-uppercase text-center w-100">welcome</h1>
    </div>
    <div class="form-group mb-3">
        <p class="text-center ">Please enter your Shopify URL</p>
    </div>

    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Store name" name="shop"
               value="{{ preg_replace('#\.myshopify\.com#mis', '', request()->get('shop')) }}">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" disabled id="button-addon2">.myshopify.com</button>
        </div>
    </div>
    <div class="form-group mb-3">
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </div>
    <div class="form-group mb-3">
        Don't have a Shopify store yet? <a href="#">Create store</a>
    </div>
</form>
</body>
@include('layouts.footer')
<script type="text/javascript">
    $(function () {
        $('form').submit(function () {
            let form = $(this);
            console.log('form.serialize()', form.serialize());
            $.ajax({
                method: form.attr('method'),
                url: form.attr('action'),
                headers: {
                    Accept: 'application/json',
                },
                data: form.serialize(),
                beforeSend: function (xhr) {
                },
                success: function (response, status, xhr) {
                    console.log('response', response);
                    location.assign(response.url);
                },
                error: function (response, status, xhr) {
                    alert(error_message(response));
                }
            });
            return false;
        });
    });
</script>
