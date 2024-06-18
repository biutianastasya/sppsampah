<?php

namespace PHPMaker2021\sppsampah;

// Page object
$ReportDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var freportdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    freportdelete = currentForm = new ew.Form("freportdelete", "delete");
    loadjs.done("freportdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.report) ew.vars.tables.report = <?= JsonEncode(GetClientVar("tables", "report")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="freportdelete" id="freportdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="report">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_report_id" class="report_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lokasi->Visible) { // lokasi ?>
        <th class="<?= $Page->lokasi->headerCellClass() ?>"><span id="elh_report_lokasi" class="report_lokasi"><?= $Page->lokasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar_terlapor->Visible) { // gambar_terlapor ?>
        <th class="<?= $Page->gambar_terlapor->headerCellClass() ?>"><span id="elh_report_gambar_terlapor" class="report_gambar_terlapor"><?= $Page->gambar_terlapor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar_terproses->Visible) { // gambar_terproses ?>
        <th class="<?= $Page->gambar_terproses->headerCellClass() ?>"><span id="elh_report_gambar_terproses" class="report_gambar_terproses"><?= $Page->gambar_terproses->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <th class="<?= $Page->status_id->headerCellClass() ?>"><span id="elh_report_status_id" class="report_status_id"><?= $Page->status_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_report_keterangan" class="report_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_laporan->Visible) { // tanggal_laporan ?>
        <th class="<?= $Page->tanggal_laporan->headerCellClass() ?>"><span id="elh_report_tanggal_laporan" class="report_tanggal_laporan"><?= $Page->tanggal_laporan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_diproses->Visible) { // tanggal_diproses ?>
        <th class="<?= $Page->tanggal_diproses->headerCellClass() ?>"><span id="elh_report_tanggal_diproses" class="report_tanggal_diproses"><?= $Page->tanggal_diproses->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_id" class="report_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lokasi->Visible) { // lokasi ?>
        <td <?= $Page->lokasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_lokasi" class="report_lokasi">
<span<?= $Page->lokasi->viewAttributes() ?>>
<?= $Page->lokasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar_terlapor->Visible) { // gambar_terlapor ?>
        <td <?= $Page->gambar_terlapor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_gambar_terlapor" class="report_gambar_terlapor">
<span>
<?= GetFileViewTag($Page->gambar_terlapor, $Page->gambar_terlapor->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar_terproses->Visible) { // gambar_terproses ?>
        <td <?= $Page->gambar_terproses->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_gambar_terproses" class="report_gambar_terproses">
<span>
<?= GetFileViewTag($Page->gambar_terproses, $Page->gambar_terproses->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <td <?= $Page->status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_status_id" class="report_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_keterangan" class="report_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_laporan->Visible) { // tanggal_laporan ?>
        <td <?= $Page->tanggal_laporan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_tanggal_laporan" class="report_tanggal_laporan">
<span<?= $Page->tanggal_laporan->viewAttributes() ?>>
<?= $Page->tanggal_laporan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_diproses->Visible) { // tanggal_diproses ?>
        <td <?= $Page->tanggal_diproses->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_tanggal_diproses" class="report_tanggal_diproses">
<span<?= $Page->tanggal_diproses->viewAttributes() ?>>
<?= $Page->tanggal_diproses->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
