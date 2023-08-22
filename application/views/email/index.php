<div class="mt-4">
    <div class="container">
        <div class="row g-3">
            <div class="col-sm-6">
                <form id="formkirim" action="<?= base_url('index.php/email/kirim') ?>" method="post">
                    <div class="card">
                        <h5 class="card-header">PHPMailer</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">SMTP Host</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="smtphost" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">SMTP User</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="email" class="form-control" name="smtpuser" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">SMTP Password</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="password" class="form-control" name="smtppass" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">SMTP Secure</label>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select" name="smtpsecure" required>
                                            <option value="tls" selected>TLS</option>
                                            <option value="ssl">SSL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">SMTP Port</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="number" class="form-control" name="smtpport" required value="587">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">To</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="email" class="form-control" name="emailto" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">Subject</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="emailsubject" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="col-form-label">Message</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="emailmessage" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $("#formkirim").on('submit', function(e) {
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
                    console.log(res);
                }
            });
        })
    });
</script>