<?php

namespace PHPMaker2021\sppsampah;

// Page object
$ReportAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var freportadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    freportadd = currentForm = new ew.Form("freportadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "report")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.report)
        ew.vars.tables.report = currentTable;
    freportadd.addFields([
        ["lokasi", [fields.lokasi.visible && fields.lokasi.required ? ew.Validators.required(fields.lokasi.caption) : null], fields.lokasi.isInvalid],
        ["gambar_terlapor", [fields.gambar_terlapor.visible && fields.gambar_terlapor.required ? ew.Validators.fileRequired(fields.gambar_terlapor.caption) : null], fields.gambar_terlapor.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = freportadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    freportadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    freportadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    freportadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("freportadd");
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
<form name="freportadd" id="freportadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="report">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->lokasi->Visible) { // lokasi ?>
    <div id="r_lokasi" class="form-group row">
        <label id="elh_report_lokasi" for="x_lokasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lokasi->caption() ?><?= $Page->lokasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lokasi->cellAttributes() ?>>
<span id="el_report_lokasi">
<textarea data-table="report" data-field="x_lokasi" name="x_lokasi" id="x_lokasi" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->lokasi->getPlaceHolder()) ?>"<?= $Page->lokasi->editAttributes() ?> aria-describedby="x_lokasi_help"><?= $Page->lokasi->EditValue ?></textarea>
<?= $Page->lokasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lokasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gambar_terlapor->Visible) { // gambar_terlapor ?>
    <div id="r_gambar_terlapor" class="form-group row">
        <label id="elh_report_gambar_terlapor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar_terlapor->caption() ?><?= $Page->gambar_terlapor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar_terlapor->cellAttributes() ?>>
<span id="el_report_gambar_terlapor">
<div id="fd_x_gambar_terlapor">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar_terlapor->title() ?>" data-table="report" data-field="x_gambar_terlapor" name="x_gambar_terlapor" id="x_gambar_terlapor" lang="<?= CurrentLanguageID() ?>"<?= $Page->gambar_terlapor->editAttributes() ?><?= ($Page->gambar_terlapor->ReadOnly || $Page->gambar_terlapor->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_terlapor_help">
        <label class="custom-file-label ew-file-label" for="x_gambar_terlapor"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->gambar_terlapor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gambar_terlapor->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_gambar_terlapor" id= "fn_x_gambar_terlapor" value="<?= $Page->gambar_terlapor->Upload->FileName ?>">
<input type="hidden" name="fa_x_gambar_terlapor" id= "fa_x_gambar_terlapor" value="0">
<input type="hidden" name="fs_x_gambar_terlapor" id= "fs_x_gambar_terlapor" value="510">
<input type="hidden" name="fx_x_gambar_terlapor" id= "fx_x_gambar_terlapor" value="<?= $Page->gambar_terlapor->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_gambar_terlapor" id= "fm_x_gambar_terlapor" value="<?= $Page->gambar_terlapor->UploadMaxFileSize ?>">
</div>
<table id="ft_x_gambar_terlapor" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_report_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_report_keterangan">
<textarea data-table="report" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
