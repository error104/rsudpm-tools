<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th></th>

                <th>KETERANGAN</th>
                <th>URL</th>
                <th width="200">JENIS DOK</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($doc as $i => $d) {
            ?>
                <tr class="<?= $d->HEADER ? 'fw-bold' : '' ?>">
                    <td>
                        <div class="btn-group"><button type="button" class="btn btn-danger btn-sm">Hapus</button><button type="button" class="btn btn-primary btn-sm" onclick="edit(this)" data-id="<?= $d->DOC_ID ?>">edit</button></div>
                    </td>
                    <td>
                        <div class="d-flex"><span class="me-2"><?= $d->DOC_INDEX ? $d->DOC_INDEX . '. ' : '' ?></span><span><?= $d->KETERANGAN ?></span>
                    </td>
                    <td><?= $d->URL_FILE ?></td>
                    <td><?= $d->JENISDOC ?></td>
                </tr>
                <?php
                $data['DOC_ID'] = $d->DOC_ID;
                $data['ket'] = $ket;
                $data['jenis'] = $jenis;
                $child = $this->md->getdocchildlist($data)->result();
                if ($child) {
                    foreach ($child as $j => $e) {
                ?>
                        <tr>
                            <td>
                                <div class="btn-group"><button type="button" class="btn btn-danger btn-sm">hapus</button><button type="button" class="btn btn-primary btn-sm" onclick="edit(this)" data-id="<?= $e->DOC_ID ?>">edit</button></div>
                            </td>
                            <td class="ps-4">
                                <div class="d-flex"><span class="me-2"><?= $e->DOC_INDEX ? $e->DOC_INDEX . '. ' : '' ?></span><span><?= $e->KETERANGAN ?></span>
                            </td>
                            <td><?= $e->URL_FILE ?></td>
                            <td><?= $e->JENISDOC ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>