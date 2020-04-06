@include('layouts.header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<body class="bg-light">
<div class="row ml-4 mt-4">
    <div class="col-8">
        <table id="example" class=" table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Messages</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $key => $product)
                <tr>
                    <td>
                        <a href="https://{{ request()->get('shop') }}/products/{{ $product->handle }}" target="_blank" class="">
                            {{ $product->shopify_id }}
                        </a>
                    </td>
                    <td>
                        {{ $product->title }}
                    </td>
                    <td>
                        <form method="post" action="/message"
                            data-product_id="{{ $product->id }}"
                              x-data="messages()"
                              x-init='
                                list = [{!! json_encode($messages[$product->id]) !!}][0];
                                '>
                            @csrf
                            <div class="mt-3">
                                <button
                                    @click="open = !open; "
                                    type="button" class="btn btn-success w-100">
                                    Set message to products <span class="" x-html="list.length ? `(${list.length})` : ``"></span>
                                    <i
                                        :class="open ? 'ml-2 fa fa-chevron-up' : 'ml-2 fa fa-chevron-down'"
                                        class=""></i>
                                </button>
                            </div>
                            <ul x-show="open"
                                class="list-group list-group-flush mt-3 w-100">
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
                                <label class="d-block w-100 mt-2">
                                    <span class="d-block">Message</span>
                                    <textarea class="form-control mt-2 w-100" x-ref="content" name="content" rows="3"></textarea>
                                </label>
                            </div>
                            <div
                                x-show="open"
                                class="mt-3 text-right w-100 ">
                                <button
                                    @click="post({{ $product->id }});$event.preventDefault();"
                                    type="submit" class="btn btn-success">Save</button>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>

<script type="text/javascript">
    function messages() {
        return {
            open: false,
            list: [],
            post(product_id) {
                $.post(`/message`, $(`form[data-product_id="${product_id}"]`).serialize())
                    .done((response) => {
                        this.list.push(response);
                        $(`form[data-product_id="${product_id}"]`).find('[name=content]').val('');
                    })
                    .fail(function(xhr, status, error) {
                        alert(error_message(xhr));
                    });
            }
        }
    }
</script>
@include('layouts.footer')
<script type="text/javascript">
    $(document).on('click', '[data-product_id]', function () {
        let product_id = $(this).attr('data-product_id');
        console.log('product_id', product_id);
        return false;
    });
    $(document).ready(function() {
        $('#example').DataTable({
                "order": [[ 0, "desc" ]]
            }
        );
    } );
</script>
