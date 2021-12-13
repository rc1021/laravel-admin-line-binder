<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        <div class="input-group">

            @if ($prepend)
            <span class="input-group-addon">{!! $prepend !!}</span>
            @endif

            <input {!! $attributes !!} />

            @if ($append)
                <span class="input-group-btn clearfix">{!! $append !!}</span>
            @endif

        </div>

        @include('admin::form.help-block')
    </div>
</div>

<script>
    var status = "{{Session::get('status')}}";
    if ( status !== ""){
        setTimeout(function(){
            toastr.success(status);
        }, 500);
    }
</script>
