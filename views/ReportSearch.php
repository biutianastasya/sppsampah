<?php

namespace PHPMaker2021\sppsampah;

// Page object
$ReportSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var freportsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    freportsearch = currentAdvancedSearchForm = new ew.Form("freportsearch", "search");
    <?php } else { ?>
    freportsearch = currentForm = new ew.Form("freportsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "report")) ?>,
        fields = currentTable.fields;
    freportsearch.addFields([
        ["lokasi", [], fields.lokasi.isInvalid],
        ["tanggal_laporan", [ew.Validators.datetime(1)], fields.tanggal_laporan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        freportsearch.setInvalid();
    });

    // Validate form
    freportsearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    freportsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    freportsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("freportsearch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="freportsearch" id="freportsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="report">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->lokasi->Visible) { // lokasi ?>
    <div id="r_lokasi" class="form-group row">
        <label for="x_lokasi" class="<?= $Page->LeftColumnClass ?>"><span id="elh_report_lokasi"><?= $Page->lokasi->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_lokasi" id="z_lokasi" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lokasi->cellAttributes() ?>>
            <span id="el_report_lokasi" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->lokasi->getInputTextType() ?>" data-table="report" data-field="x_lokasi" name="x_lokasi" id="x_lokasi" maxlength="510" placeholder="<?= HtmlEncode($Page->lokasi->getPlaceHolder()) ?>" value="<?= $Page->lokasi->EditValue ?>"<?= $Page->lokasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->lokasi->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_laporan->Visible) { // tanggal_laporan ?>
    <div id="r_tanggal_laporan" class="form-group row">
        <label for="x_tanggal_laporan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_report_tanggal_laporan"><?= $Page->tanggal_laporan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("<>") ?>
<input type="hidden" name="z_tanggal_laporan" id="z_tanggal_laporan" value="&lt;&gt;">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_laporan->cellAttributes() ?>>
            <span id="el_report_tanggal_laporan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->tanggal_laporan->getInputTextType() ?>" data-table="report" data-field="x_tanggal_laporan" data-format="1" name="x_tanggal_laporan" id="x_tanggal_laporan" maxlength="19" placeholder="<?= HtmlEncode($Page->tanggal_laporan->getPlaceHolder()) ?>" value="<?= $Page->tanggal_laporan->EditValue ?>"<?= $Page->tanggal_laporan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tanggal_laporan->getErrorMessage(false) ?></div>
<?php if (!$Page->tanggal_laporan->ReadOnly && !$Page->tanggal_laporan->Disabled && !isset($Page->tanggal_laporan->EditAttrs["readonly"]) && !isset($Page->tanggal_laporan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("freportsearch", "x_tanggal_laporan", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="location.reload();"><?= $Language->phrase("Reset") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
