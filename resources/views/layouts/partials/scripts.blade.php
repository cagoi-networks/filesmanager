<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
<script>
    //See https://laracasts.com/discuss/channels/vue/use-trans-in-vuejs
    window.trans = @php
        // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            $trans[$filename] = trans($filename);
        }
        $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
        echo json_encode($trans);
    @endphp

    const op = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function() {
        const resp = op.apply(this, arguments);
        this.setRequestHeader('X-CSRF-Token', $('meta[name=csrf-token]').attr('content'));
        return resp;
    };
</script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/fileUploader.js') }}" type="text/javascript"></script>

