<div class="form-group">
    {!!Form::label('file', 'Imagen relacionada', array('class' => 'control-label col-sm-2'))!!}
    <div class="col-md-6">
        @if(count($user->attachment) > 0)
        <div class="wrapper">
            <div id="image_refresh">
                <img src="{!! URL::to('/') . DIRECTORY_SEPARATOR . $user->attachment[0]->upload_path . DIRECTORY_SEPARATOR .  $user->attachment[0]->name !!}" style="max-height: 100px"/><br><br>
            </div>
        </div>
        @endif
    </div>
</div>
