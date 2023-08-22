<div class="card" id="formdokumen" style="position: fixed;left:0;right:0;z-index:2001;top:0;">
    <div class="card-body">
        <div class="formedit">

        </div>
        <div class="formbaru">
            <form id="formdok" action="<?= base_url('index.php/dokumen/insertdok') ?>" method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-sm-2">
                        <div>
                            <label for="exampleInputEmail1" class="form-label">Jenis Dokumen</label>
                            <select class="form-control" name="jenisdok" required>
                                <option value="" selected empty>Pilih ...</option>
                                <?php
                                foreach ($jnsdoc as $d) {
                                ?>
                                    <option value="<?= $d->JNS_DOC ?>"><?= $d->KETERANGAN ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <label for="exampleInputEmail1" class="form-label">Kepala</label>
                        <div>
                            <input class="form-check-input" type="checkbox" name="header" value="1">
                        </div>
                    </div>
                    <div class="col-sm-2" id="header">
                        <div>
                            <label for="exampleInputEmail1" class="form-label">Kepala</label>
                            <select class="form-control" name="headerdok">
                                <option value="" selected>Pilih ...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div>
                            <label for="exampleInputEmail1" class="form-label">Index</label>
                            <input type="text" class="form-control" name="index" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div>
                            <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div>
                            <label for="exampleInputEmail1" class="form-label">Url Dokumen</label>
                            <input type="text" class="form-control" name="url">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div>
                            <textarea name="deskripsi" id="editor"></textarea>
                        </div>

                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="data">
    <div class="p-3">
        <div class="row g-3">
            <div class="col-sm-2">
                <div>
                    <!--  <label for="exampleInputEmail1" class="form-label">Jenis Dokumen</label> -->
                    <select class="form-control" id="jenisdok" required onchange="datadoc()">
                        <option value="" selected empty>Pilih ...</option>
                        <?php
                        foreach ($jnsdoc as $d) {
                        ?>
                            <option value="<?= $d->JNS_DOC ?>"><?= $d->KETERANGAN ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <!--  <label for="exampleInputEmail1" class="form-label">Keterangan</label> -->
                    <input type="text" class="form-control" id="keterangan" required placeholder="Keterangan ..." onkeyup="datadoc()">
                </div>
            </div>
        </div>
    </div>
    <div id="data-list"></div>
</div>
<script>
    function datadoc() {
        var jenis = $("#jenisdok").val();
        var ket = $("#keterangan").val();
        $.post(
            '<?= base_url('index.php/dokumen/data') ?>', {
                jenis: jenis,
                ket: ket
            },
            function(res) {
                $("#data-list").html(res);
            }
        );
    }

    function edit(e) {
        $.post(
            '<?= base_url('index.php/dokumen/editdoc') ?>', {
                id: $(e).attr('data-id')
            },
            function(res) {
                $(".formedit").html(res);
                $(".formbaru").hide();
            }
        );
    }

    function resetform() {
        $("#formdok")[0].reset();
        $("#header").removeClass('d-none');
    }

    function bataledit() {
        $(".formedit").html('');
        $(".formbaru").show();
    }
    document.addEventListener('DOMContentLoaded', function() {

        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

        $("[name='header']").on('change', function() {
            if ($(this).is(':checked')) {
                $("#header").addClass('d-none');
            } else {
                $("#header").removeClass('d-none');
            }
        })



        $("#formdok").on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    datadoc();
                    resetform();
                }
            });
        })

        $("#formdok [name='headerdok']").on("focus", function() {
            $.post(
                '<?= base_url('index.php/dokumen/getdocheader') ?>', {
                    jenis: $("[name='jenisdok']").val()
                },
                function(res) {

                    if (res) {
                        $("[name='headerdok'] option[data-val]").remove();
                        $("[name='headerdok']").append(res);
                    } else {
                        $("[name='headerdok'] option[data-val]").remove();
                    }
                }
            );
        })
        setTimeout(function() {
            var h = $("#formdokumen").outerHeight();
            $("#data").css('margin-top', h);
            datadoc();
        }, 500)
    });
</script>