<?php

namespace PHPMaker2021\sppsampah;

// Page object
$ReportEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var freportedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    freportedit = currentForm = new ew.Form("freportedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "report")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.report)
        ew.vars.tables.report = currentTable;
    freportedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["gambar_terproses", [fields.gambar_terproses.visible && fields.gambar_terproses.required ? ew.Validators.fileRequired(fields.gambar_terproses.caption) : null], fields.gambar_terproses.isInvalid],
        ["status_id", [fields.status_id.visible && fields.status_id.required ? ew.Validators.required(fields.status_id.caption) : null], fields.status_id.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["tanggal_diproses", [fields.tanggal_diproses.visible && fields.tanggal_diproses.required ? ew.Validators.required(fields.tanggal_diproses.caption) : null, ew.Validators.datetime(1)], fields.tanggal_diproses.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = freportedit,
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
    freportedit.validate = function () {
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
    freportedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    freportedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    freportedit.lists.status_id = <?= $Page->status_id->toClientList($Page) ?>;
    loadjs.done("freportedit");
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
<form name="freportedit" id="freportedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="report">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_report_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_report_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="report" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gambar_terproses->Visible) { // gambar_terproses ?>
    <div id="r_gambar_terproses" class="form-group row">
        <label id="elh_report_gambar_terproses" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar_terproses->caption() ?><?= $Page->gambar_terproses->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar_terproses->cellAttributes() ?>>
<span id="el_report_gambar_terproses">
<div id="fd_x_gambar_terproses">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar_terproses->title() ?>" data-table="report" data-field="x_gambar_terproses" name="x_gambar_terproses" id="x_gambar_terproses" lang="<?= CurrentLanguageID() ?>"<?= $Page->gambar_terproses->editAttributes() ?><?= ($Page->gambar_terproses->ReadOnly || $Page->gambar_terproses->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_terproses_help">
        <label class="custom-file-label ew-file-label" for="x_gambar_terproses"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->gambar_terproses->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gambar_terproses->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_gambar_terproses" id= "fn_x_gambar_terproses" value="<?= $Page->gambar_terproses->Upload->FileName ?>">
<input type="hidden" name="fa_x_gambar_terproses" id= "fa_x_gambar_terproses" value="<?= (Post("fa_x_gambar_terproses") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_gambar_terproses" id= "fs_x_gambar_terproses" value="510">
<input type="hidden" name="fx_x_gambar_terproses" id= "fx_x_gambar_terproses" value="<?= $Page->gambar_terproses->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_gambar_terproses" id= "fm_x_gambar_terproses" value="<?= $Page->gambar_terproses->UploadMaxFileSize ?>">
</div>
<table id="ft_x_gambar_terproses" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_id->Visible) { // status_id ?>
    <div id="r_status_id" class="form-group row">
        <label id="elh_report_status_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_id->caption() ?><?= $Page->status_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_id->cellAttributes() ?>>
<span id="el_report_status_id">
<div class="input-group ew-lookup-list" aria-describedby="x_status_id_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_status_id"><?= EmptyValue(strval($Page->status_id->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->status_id->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->status_id->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->status_id->ReadOnly || $Page->status_id->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_status_id',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->status_id->getErrorMessage() ?></div>
<?= $Page->status_id->getCustomMessage() ?>
<?= $Page->status_id->Lookup->getParamTag($Page, "p_x_status_id") ?>
<input type="hidden" is="selection-list" data-table="report" data-field="x_status_id" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->status_id->displayValueSeparatorAttribute() ?>" name="x_status_id" id="x_status_id" value="<?= $Page->status_id->CurrentValue ?>"<?= $Page->status_id->editAttributes() ?>>
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
<?php if ($Page->tanggal_diproses->Visible) { // tanggal_diproses ?>
    <div id="r_tanggal_diproses" class="form-group row">
        <label id="elh_report_tanggal_diproses" for="x_tanggal_diproses" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_diproses->caption() ?><?= $Page->tanggal_diproses->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_diproses->cellAttributes() ?>>
<span id="el_report_tanggal_diproses">
<input type="<?= $Page->tanggal_diproses->getInputTextType() ?>" data-table="report" data-field="x_tanggal_diproses" data-format="1" name="x_tanggal_diproses" id="x_tanggal_diproses" maxlength="19" placeholder="<?= HtmlEncode($Page->tanggal_diproses->getPlaceHolder()) ?>" value="<?= $Page->tanggal_diproses->EditValue ?>"<?= $Page->tanggal_diproses->editAttributes() ?> aria-describedby="x_tanggal_diproses_help">
<?= $Page->tanggal_diproses->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_diproses->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_diproses->ReadOnly && !$Page->tanggal_diproses->Disabled && !isset($Page->tanggal_diproses->EditAttrs["readonly"]) && !isset($Page->tanggal_diproses->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportedit", "datetimepicker"], function() {
    ew.createDateTimePicker("freportedit", "x_tanggal_diproses", {"ignoreReadonly":true,"useCurrent":false,"format":1});
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
