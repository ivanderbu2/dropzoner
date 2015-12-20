<script src="/vendor/dropzoner/main.js"></script>

<div>

    <form action='<?php echo route("dropzoner.upload") ?>' class='dropzone'>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

        <div class="dz-message"></div>

        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>

        <div class="dropzone-previews" id="dropzonePreview"></div>

    </form>

</div>

