<form id="formedit" action="<?= base_url('index.php/dokumen/updatedok') ?>" method="post" enctype="multipart/form-data">
    <div class="row g-3">
        <div class="col-sm-2">
            <div>
                <label for="exampleInputEmail1" class="form-label">Jenis Dokumen</label>
                <select class="form-control" name="jenisdok" required>
                    <option value="" disabled selected>Pilih ...</option>
                    <?php
                    foreach ($jnsdoc as $d) {
                        $selected = $doc->JNS_DOC == $d->JNS_DOC ? 'selected' : '';
                    ?>
                        <option value="<?= $d->JNS_DOC ?>" <?= $selected ?>><?= $d->KETERANGAN ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-sm-1">
            <label for="exampleInputEmail1" class="form-label">Kepala</label>
            <div>
                <input class="form-check-input" type="checkbox" name="header" value="1" <?= $doc->HEADER ? 'checked' : '' ?>>
            </div>
        </div>

        <div class="col-sm-2 <?= $doc->HEADER ? 'd-none' : '' ?>" id="header">
            <div>
                <label for="exampleInputEmail1" class="form-label">Kepala</label>
                <select class="form-control" name="headerdok">
                    <option value="" disabled selected>Pilih ...</option>
                    <?php
                    if ($doc->DOC_HEADER) {
                    ?>
                        <option value="<?= $doc->DOC_HEADER ?>" selected><?= $doc->KEPALA ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-sm-1">
            <div>
                <label for="exampleInputEmail1" class="form-label">Index</label>
                <input type="text" class="form-control" name="index" required value="<?= $doc->DOC_INDEX ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div>
                <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" required value="<?= $doc->KETERANGAN ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div>
                <label for="exampleInputEmail1" class="form-label">Url Dokumen</label>
                <input type="text" class="form-control" name="url" value="<?= $doc->URL_FILE ?>">
            </div>
        </div>
        <div class="col-sm-12">
            <div>
                <textarea name="deskripsi" id="editor"><?= $doc->DESKRIPSI ?></textarea>
            </div>

        </div>
    </div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" onclick="bataledit()">Batal</button>
    </div>
</form>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    $("#formedit [name='header']").on('change', function() {
        if ($(this).is(':checked')) {
            $("#formedit #header").addClass('d-none');
        } else {
            $("#formedit #header").removeClass('d-none');
        }
    })
    $("#formedit").on('submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        data.append('id', '<?= $doc->DOC_ID ?>');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res) {
                datadoc();
                $(".formedit").html('');
                $(".formbaru").show();
            }
        });
    })
    $("#formedit [name='headerdok']").on('focus', function() {
        $.post(
            '<?= base_url('index.php/dokumen/getdocheader') ?>', {
                jenis: $("#formedit [name='jenisdok']").val()
            },
            function(res) {
                console.log(res);
                if (res) {
                    $("[name='headerdok'] option[data-val]").remove();
                    $("[name='headerdok']").append(res);
                } else {
                    $("#formedit [name='headerdok'] option[data-val]").remove();
                }
            }
        );
    })
    //});
</script>