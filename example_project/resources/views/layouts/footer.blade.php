</html>
<script type="text/javascript">
    function error_message(response){
        response = response.responseJSON;
        let contents = [];
        if (typeof response == 'undefined') {
            contents = [...contents, 'No data return'];
        } else if (response.errors) {
            $.each(response.errors, function (key, val) {
                if (Array.isArray(val)) {
                    $.each(val, function (key1, val1) {
                        contents = [...contents, val1];
                    });
                } else {
                    contents = [...contents, val];
                }
            });
        } else {
            contents = [...contents, response.message];
        }
        return contents;
    }
</script>
