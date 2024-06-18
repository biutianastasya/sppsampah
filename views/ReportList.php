<?php

namespace PHPMaker2021\sppsampah;

// Page object
$ReportList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var freportlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    freportlist = currentForm = new ew.Form("freportlist", "list");
    freportlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("freportlist");
});
var freportlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    freportlistsrch = currentSearchForm = new ew.Form("freportlistsrch");

    // Dynamic selection lists

    // Filters
    freportlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("freportlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> report">
<form name="freportlist" id="freportlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="report">
<div id="gmp_report" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_reportlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_report_id" class="report_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->lokasi->Visible) { // lokasi ?>
        <th data-name="lokasi" class="<?= $Page->lokasi->headerCellClass() ?>"><div id="elh_report_lokasi" class="report_lokasi"><?= $Page->renderSort($Page->lokasi) ?></div></th>
<?php } ?>
<?php if ($Page->gambar_terlapor->Visible) { // gambar_terlapor ?>
        <th data-name="gambar_terlapor" class="<?= $Page->gambar_terlapor->headerCellClass() ?>"><div id="elh_report_gambar_terlapor" class="report_gambar_terlapor"><?= $Page->renderSort($Page->gambar_terlapor) ?></div></th>
<?php } ?>
<?php if ($Page->gambar_terproses->Visible) { // gambar_terproses ?>
        <th data-name="gambar_terproses" class="<?= $Page->gambar_terproses->headerCellClass() ?>"><div id="elh_report_gambar_terproses" class="report_gambar_terproses"><?= $Page->renderSort($Page->gambar_terproses) ?></div></th>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
        <th data-name="status_id" class="<?= $Page->status_id->headerCellClass() ?>"><div id="elh_report_status_id" class="report_status_id"><?= $Page->renderSort($Page->status_id) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_report_keterangan" class="report_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_laporan->Visible) { // tanggal_laporan ?>
        <th data-name="tanggal_laporan" class="<?= $Page->tanggal_laporan->headerCellClass() ?>"><div id="elh_report_tanggal_laporan" class="report_tanggal_laporan"><?= $Page->renderSort($Page->tanggal_laporan) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_diproses->Visible) { // tanggal_diproses ?>
        <th data-name="tanggal_diproses" class="<?= $Page->tanggal_diproses->headerCellClass() ?>"><div id="elh_report_tanggal_diproses" class="report_tanggal_diproses"><?= $Page->renderSort($Page->tanggal_diproses) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_report", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lokasi->Visible) { // lokasi ?>
        <td data-name="lokasi" <?= $Page->lokasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_lokasi">
<span<?= $Page->lokasi->viewAttributes() ?>>
<?= $Page->lokasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gambar_terlapor->Visible) { // gambar_terlapor ?>
        <td data-name="gambar_terlapor" <?= $Page->gambar_terlapor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_gambar_terlapor">
<span>
<?= GetFileViewTag($Page->gambar_terlapor, $Page->gambar_terlapor->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gambar_terproses->Visible) { // gambar_terproses ?>
        <td data-name="gambar_terproses" <?= $Page->gambar_terproses->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_gambar_terproses">
<span>
<?= GetFileViewTag($Page->gambar_terproses, $Page->gambar_terproses->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_id->Visible) { // status_id ?>
        <td data-name="status_id" <?= $Page->status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_status_id">
<span<?= $Page->status_id->viewAttributes() ?>>
<?= $Page->status_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_laporan->Visible) { // tanggal_laporan ?>
        <td data-name="tanggal_laporan" <?= $Page->tanggal_laporan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_tanggal_laporan">
<span<?= $Page->tanggal_laporan->viewAttributes() ?>>
<?= $Page->tanggal_laporan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_diproses->Visible) { // tanggal_diproses ?>
        <td data-name="tanggal_diproses" <?= $Page->tanggal_diproses->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_report_tanggal_diproses">
<span<?= $Page->tanggal_diproses->viewAttributes() ?>>
<?= $Page->tanggal_diproses->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("report");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
