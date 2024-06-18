<?php

namespace PHPMaker2021\sppsampah;

// Page object
$ReportView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var freportview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    freportview = currentForm = new ew.Form("freportview", "view");
    loadjs.done("freportview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.report) ew.vars.tables.report = <?= JsonEncode(GetClientVar("tables", "report")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="freportview" id="freportview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="report">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_report_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lokasi->Visible) { // lokasi ?>
    <tr id="r_lokasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_lokasi"><?= $Page->lokasi->caption() ?></span></td>
        <td data-name="lokasi" <?= $Page->lokasi->cellAttributes() ?>>
<span id="el_report_lokasi">
<span<?= $Page->lokasi->viewAttributes() ?>>
<?= $Page->lokasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gambar_terlapor->Visible) { // gambar_terlapor ?>
    <tr id="r_gambar_terlapor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_gambar_terlapor"><?= $Page->gambar_terlapor->caption() ?></span></td>
        <td data-name="gambar_terlapor" <?= $Page->gambar_terlapor->cellAttributes() ?>>
<span id="el_report_gambar_terlapor">
<span>
<?= GetFileViewTag($Page->gambar_terlapor, $Page->gambar_terlapor->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gambar_terproses->Visible) { // gambar_terproses ?>
    <tr id="r_gambar_terproses">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_gambar_terproses"><?= $Page->gambar_terproses->caption() ?></span></td>
        <td data-name="gambar_terproses" <?= $Page->gambar_terproses->cellAttributes() ?>>
<span id="el_report_gambar_terproses">
<span>
<?= GetFileViewTag($Page->gambar_terproses, $Page->gambar_terproses->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <tr id="r_status_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_status_id"><?= $Page->status_id->caption() ?></span></td>
        <td data-name="status_id" <?= $Page->status_id->cellAttributes() ?>>
<span id="el_report_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_report_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_laporan->Visible) { // tanggal_laporan ?>
    <tr id="r_tanggal_laporan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_tanggal_laporan"><?= $Page->tanggal_laporan->caption() ?></span></td>
        <td data-name="tanggal_laporan" <?= $Page->tanggal_laporan->cellAttributes() ?>>
<span id="el_report_tanggal_laporan">
<span<?= $Page->tanggal_laporan->viewAttributes() ?>>
<?= $Page->tanggal_laporan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_diproses->Visible) { // tanggal_diproses ?>
    <tr id="r_tanggal_diproses">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_report_tanggal_diproses"><?= $Page->tanggal_diproses->caption() ?></span></td>
        <td data-name="tanggal_diproses" <?= $Page->tanggal_diproses->cellAttributes() ?>>
<span id="el_report_tanggal_diproses">
<span<?= $Page->tanggal_diproses->viewAttributes() ?>>
<?= $Page->tanggal_diproses->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
