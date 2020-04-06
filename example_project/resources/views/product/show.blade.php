@include('layouts.header')
@php
    $product['image']['src'] = empty($product['image']['src']) ? '/images/2.png': $product['image']['src'];
@endphp
<?php
//dd($product['variants']);
?>
<style>
    .strike {
        text-decoration: line-through;
    }
</style>
<body class="bg-light position-relative">
<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="/shop/{{ $shop->id }}" class="">
                <h3 class="">
                    <i class="fa fa-arrow-left"></i>
                </h3>
            </a>
            <hr>
        </div>
        <div class="col-6" x-data="{images: []}">
            <img src="{{ $product['image']['src'] }}" class="img-fluid" alt="Responsive image">
        </div>
        <div class="col-6">
            <h2 class="">{{ $product['title'] }}</h2>
            <div class="text-secondary mt-3">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <div class="d-flex flex-row mt-3">
                <?php foreach ($product['variants'] as $key => $val){?>
                    <h4 class="">{{ $val['price'] }} <sup>đ</sup></h4>
                <?php } ?>
{{--                <h4 class="ml-4 strike text-secondary">2.823.234 <sup>đ</sup></h4>--}}
            </div>
            <div class="mt-3"><b class="">Variants</b></div>
            <div class="mt-3">
                <?php foreach ($product['variants'] as $key => $val){?>
                    <button type="button" class="btn btn-dark">{{ $val['title'] }}</button>
                <?php }?>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-warning w-50">Add to cart</button>
            </div>
            <form method="post" action="/message"
                  x-data="messages()"
                  x-init="
                    $watch('list', list => console.log('list', list));
                    setInterval(function(){ get(); }, 3000);
                    get();
                    ">
                @csrf
                <div class="mt-3">
                    <button
                        @click="open = !open; "
                        type="button" class="btn btn-success w-50">
                        Set message to products <span class="" x-html="list.length ? `(${list.length})` : ``"></span>
                        <i
                            :class="open ? 'ml-2 fa fa-chevron-up' : 'ml-2 fa fa-chevron-down'"
                            class=""></i>
                    </button>
                </div>
                <ul x-show="open"
                    class="list-group list-group-flush mt-3 w-50">
                    <li class="list-group-item">
                        <a href="/message" >All messages</a>
                    </li>
                    <template x-for="(value, key) in list" >
                        <li class="list-group-item">
                            <div class="" x-html="value.content"></div>
                            <div class="text-secondary" x-html="value.created_at"></div>
                        </li>
                    </template>
                </ul>
                <div
                    x-show="open"
                    class="mt-3">
                    <h5 class="">Set message to products</h5>
                    <label class="d-block w-50 mt-2">
                        <span class="d-block">Message</span>
                        <textarea class="form-control mt-2 w-100" x-ref="content" name="content" rows="3"></textarea>
                    </label>
                </div>
                <div
                    x-show="open"
                    class="mt-3 text-right w-50 ">
                    <button
                        @click="post();$event.preventDefault();"
                        type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                </div>
            </form>
            <script type="text/javascript">
                function messages() {
                    return {
                        open: false,
                        list: [],
                        get(){
                            $.get(`/message/?product_id={{ $product['id'] }}`).then((response) => {
                                this.list = response;
                            });
                        },
                        post() {
                            $.post(`/message`, $('form').serialize())
                            .done((response) => {
                                this.list.push(response);
                                $('form').find('[name=content]').val('');
                            })
                            .fail(function(xhr, status, error) {
                                alert(error_message(xhr));
                            });
                        }
                    }
                }
            </script>
            <div class="mt-3">
                <button type="button" class="btn btn-dark w-50">Buy it now</button>
            </div>
            <div class="mt-3">
                Share:
                <a href="#" class="ml-2 text-dark"><i class="fa fa-facebook-f"></i></a>
                <a href="#" class="ml-2 text-dark"><i class="fa fa-twitter"></i></a>
                <a href="#" class="ml-2 text-dark"><i class="fa fa-pinterest"></i></a>
            </div>
            <div class="mt-3">
                <hr>
                <h5 class="">
                    Product description
                    <i class="ml-2 fa fa-chevron-down"></i>
                </h5>
                <p class="">
                    {{ $product['body_html'] }}
                </p>
            </div>
        </div>
    </div>
</div>
<div class="toast bg-success text-white" style="position: fixed; top: 3rem; right: 2rem;">
    <div class="toast-body">
        Set message to products success
    </div>
</div>
</body>
@include('layouts.footer')
