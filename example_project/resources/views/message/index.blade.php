@include('layouts.header')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<body class="bg-light">
    <div class="row ml-4">
        <div class="col-12 py-2">
            <a href="javascript:window.history.go(-1);" class="ml-5">
                <h4 class=""><i class="fa fa-arrow-left"></i></h4>
            </a>
        </div>
        <div class="col-6">
            <table id="example" class=" table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $key => $message)
                    <tr>
                        <td>{{ $message['id'] }}</td>
                        <td>
                            <a href="/product/{{ $message['product_id'] }}">{{ $products[$message['product_id']]['title'] }}</a>
                        </td>
                        <td>{{ $message['content'] }}</td>
                        <td>{{ $message['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</body>
@include('layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            "order": [[ 0, "desc" ]]
            }
        );
    } );
</script>
