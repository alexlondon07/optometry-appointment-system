  <div class="col-lg-12">
    <div class="input-group"></div>

      @if(count($company->attachment) > 0)
        <div class="wrapper">
            <div id="image_refresh">
                <img src="{!! URL::to('/') . DIRECTORY_SEPARATOR . $company->attachment[0]->upload_path . DIRECTORY_SEPARATOR .  $company->attachment[0]->name !!}" style="max-height: 100px"/><br><br>
            </div>
        </div>
        {!!Form::label('file', 'Firma Representante Legal', array('class' => 'control-label'))!!}
        @endif
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->



