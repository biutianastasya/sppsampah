<?php

namespace PHPMaker2021\sppsampah;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for report
 */
class Report extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $lokasi;
    public $gambar_terlapor;
    public $gambar_terproses;
    public $status_id;
    public $keterangan;
    public $tanggal_laporan;
    public $tanggal_diproses;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'report';
        $this->TableName = 'report';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`report`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);
        $this->BasicSearch->TypeDefault = "OR";

        // id
        $this->id = new DbField('report', 'report', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // lokasi
        $this->lokasi = new DbField('report', 'report', 'x_lokasi', 'lokasi', '`lokasi`', '`lokasi`', 201, 510, -1, false, '`lokasi`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->lokasi->Nullable = false; // NOT NULL field
        $this->lokasi->Required = true; // Required field
        $this->lokasi->Sortable = true; // Allow sort
        $this->lokasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lokasi->Param, "CustomMsg");
        $this->Fields['lokasi'] = &$this->lokasi;

        // gambar_terlapor
        $this->gambar_terlapor = new DbField('report', 'report', 'x_gambar_terlapor', 'gambar_terlapor', '`gambar_terlapor`', '`gambar_terlapor`', 201, 510, -1, true, '`gambar_terlapor`', false, false, false, 'IMAGE', 'FILE');
        $this->gambar_terlapor->Nullable = false; // NOT NULL field
        $this->gambar_terlapor->Required = true; // Required field
        $this->gambar_terlapor->Sortable = true; // Allow sort
        $this->gambar_terlapor->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gambar_terlapor->Param, "CustomMsg");
        $this->Fields['gambar_terlapor'] = &$this->gambar_terlapor;

        // gambar_terproses
        $this->gambar_terproses = new DbField('report', 'report', 'x_gambar_terproses', 'gambar_terproses', '`gambar_terproses`', '`gambar_terproses`', 201, 510, -1, true, '`gambar_terproses`', false, false, false, 'IMAGE', 'FILE');
        $this->gambar_terproses->Sortable = true; // Allow sort
        $this->gambar_terproses->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gambar_terproses->Param, "CustomMsg");
        $this->Fields['gambar_terproses'] = &$this->gambar_terproses;

        // status_id
        $this->status_id = new DbField('report', 'report', 'x_status_id', 'status_id', '`status_id`', '`status_id`', 3, 11, -1, false, '`status_id`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status_id->Required = true; // Required field
        $this->status_id->Sortable = true; // Allow sort
        $this->status_id->Lookup = new Lookup('status_id', 'status', false, 'id', ["status","","",""], [], [], [], [], [], [], '', '');
        $this->status_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status_id->Param, "CustomMsg");
        $this->Fields['status_id'] = &$this->status_id;

        // keterangan
        $this->keterangan = new DbField('report', 'report', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, 255, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // tanggal_laporan
        $this->tanggal_laporan = new DbField('report', 'report', 'x_tanggal_laporan', 'tanggal_laporan', '`tanggal_laporan`', CastDateFieldForLike("`tanggal_laporan`", 1, "DB"), 135, 19, 1, false, '`tanggal_laporan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_laporan->Sortable = true; // Allow sort
        $this->tanggal_laporan->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_laporan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_laporan->Param, "CustomMsg");
        $this->Fields['tanggal_laporan'] = &$this->tanggal_laporan;

        // tanggal_diproses
        $this->tanggal_diproses = new DbField('report', 'report', 'x_tanggal_diproses', 'tanggal_diproses', '`tanggal_diproses`', CastDateFieldForLike("`tanggal_diproses`", 1, "DB"), 135, 19, 1, false, '`tanggal_diproses`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_diproses->Sortable = true; // Allow sort
        $this->tanggal_diproses->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_diproses->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_diproses->Param, "CustomMsg");
        $this->Fields['tanggal_diproses'] = &$this->tanggal_diproses;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`report`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->lokasi->DbValue = $row['lokasi'];
        $this->gambar_terlapor->Upload->DbValue = $row['gambar_terlapor'];
        $this->gambar_terproses->Upload->DbValue = $row['gambar_terproses'];
        $this->status_id->DbValue = $row['status_id'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->tanggal_laporan->DbValue = $row['tanggal_laporan'];
        $this->tanggal_diproses->DbValue = $row['tanggal_diproses'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['gambar_terlapor']) ? [] : [$row['gambar_terlapor']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->gambar_terlapor->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->gambar_terlapor->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['gambar_terproses']) ? [] : [$row['gambar_terproses']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->gambar_terproses->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->gambar_terproses->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("reportlist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "reportview") {
            return $Language->phrase("View");
        } elseif ($pageName == "reportedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "reportadd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "ReportView";
            case Config("API_ADD_ACTION"):
                return "ReportAdd";
            case Config("API_EDIT_ACTION"):
                return "ReportEdit";
            case Config("API_DELETE_ACTION"):
                return "ReportDelete";
            case Config("API_LIST_ACTION"):
                return "ReportList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "reportlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("reportview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("reportview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "reportadd?" . $this->getUrlParm($parm);
        } else {
            $url = "reportadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("reportedit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("reportadd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("reportdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->lokasi->setDbValue($row['lokasi']);
        $this->gambar_terlapor->Upload->DbValue = $row['gambar_terlapor'];
        $this->gambar_terlapor->setDbValue($this->gambar_terlapor->Upload->DbValue);
        $this->gambar_terproses->Upload->DbValue = $row['gambar_terproses'];
        $this->gambar_terproses->setDbValue($this->gambar_terproses->Upload->DbValue);
        $this->status_id->setDbValue($row['status_id']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->tanggal_laporan->setDbValue($row['tanggal_laporan']);
        $this->tanggal_diproses->setDbValue($row['tanggal_diproses']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // lokasi

        // gambar_terlapor

        // gambar_terproses

        // status_id

        // keterangan

        // tanggal_laporan

        // tanggal_diproses

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // lokasi
        $this->lokasi->ViewValue = $this->lokasi->CurrentValue;
        $this->lokasi->ViewCustomAttributes = "";

        // gambar_terlapor
        if (!EmptyValue($this->gambar_terlapor->Upload->DbValue)) {
            $this->gambar_terlapor->ImageAlt = $this->gambar_terlapor->alt();
            $this->gambar_terlapor->ViewValue = $this->gambar_terlapor->Upload->DbValue;
        } else {
            $this->gambar_terlapor->ViewValue = "";
        }
        $this->gambar_terlapor->ViewCustomAttributes = "";

        // gambar_terproses
        if (!EmptyValue($this->gambar_terproses->Upload->DbValue)) {
            $this->gambar_terproses->ImageAlt = $this->gambar_terproses->alt();
            $this->gambar_terproses->ViewValue = $this->gambar_terproses->Upload->DbValue;
        } else {
            $this->gambar_terproses->ViewValue = "";
        }
        $this->gambar_terproses->ViewCustomAttributes = "";

        // status_id
        $curVal = trim(strval($this->status_id->CurrentValue));
        if ($curVal != "") {
            $this->status_id->ViewValue = $this->status_id->lookupCacheOption($curVal);
            if ($this->status_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->status_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->status_id->Lookup->renderViewRow($rswrk[0]);
                    $this->status_id->ViewValue = $this->status_id->displayValue($arwrk);
                } else {
                    $this->status_id->ViewValue = $this->status_id->CurrentValue;
                }
            }
        } else {
            $this->status_id->ViewValue = null;
        }
        $this->status_id->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // tanggal_laporan
        $this->tanggal_laporan->ViewValue = $this->tanggal_laporan->CurrentValue;
        $this->tanggal_laporan->ViewValue = FormatDateTime($this->tanggal_laporan->ViewValue, 1);
        $this->tanggal_laporan->ViewCustomAttributes = "";

        // tanggal_diproses
        $this->tanggal_diproses->ViewValue = $this->tanggal_diproses->CurrentValue;
        $this->tanggal_diproses->ViewValue = FormatDateTime($this->tanggal_diproses->ViewValue, 1);
        $this->tanggal_diproses->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // lokasi
        $this->lokasi->LinkCustomAttributes = "";
        $this->lokasi->HrefValue = "";
        $this->lokasi->TooltipValue = "";

        // gambar_terlapor
        $this->gambar_terlapor->LinkCustomAttributes = "";
        if (!EmptyValue($this->gambar_terlapor->Upload->DbValue)) {
            $this->gambar_terlapor->HrefValue = GetFileUploadUrl($this->gambar_terlapor, $this->gambar_terlapor->htmlDecode($this->gambar_terlapor->Upload->DbValue)); // Add prefix/suffix
            $this->gambar_terlapor->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->gambar_terlapor->HrefValue = FullUrl($this->gambar_terlapor->HrefValue, "href");
            }
        } else {
            $this->gambar_terlapor->HrefValue = "";
        }
        $this->gambar_terlapor->ExportHrefValue = $this->gambar_terlapor->UploadPath . $this->gambar_terlapor->Upload->DbValue;
        $this->gambar_terlapor->TooltipValue = "";
        if ($this->gambar_terlapor->UseColorbox) {
            if (EmptyValue($this->gambar_terlapor->TooltipValue)) {
                $this->gambar_terlapor->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->gambar_terlapor->LinkAttrs["data-rel"] = "report_x_gambar_terlapor";
            $this->gambar_terlapor->LinkAttrs->appendClass("ew-lightbox");
        }

        // gambar_terproses
        $this->gambar_terproses->LinkCustomAttributes = "";
        if (!EmptyValue($this->gambar_terproses->Upload->DbValue)) {
            $this->gambar_terproses->HrefValue = GetFileUploadUrl($this->gambar_terproses, $this->gambar_terproses->htmlDecode($this->gambar_terproses->Upload->DbValue)); // Add prefix/suffix
            $this->gambar_terproses->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->gambar_terproses->HrefValue = FullUrl($this->gambar_terproses->HrefValue, "href");
            }
        } else {
            $this->gambar_terproses->HrefValue = "";
        }
        $this->gambar_terproses->ExportHrefValue = $this->gambar_terproses->UploadPath . $this->gambar_terproses->Upload->DbValue;
        $this->gambar_terproses->TooltipValue = "";
        if ($this->gambar_terproses->UseColorbox) {
            if (EmptyValue($this->gambar_terproses->TooltipValue)) {
                $this->gambar_terproses->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->gambar_terproses->LinkAttrs["data-rel"] = "report_x_gambar_terproses";
            $this->gambar_terproses->LinkAttrs->appendClass("ew-lightbox");
        }

        // status_id
        $this->status_id->LinkCustomAttributes = "";
        $this->status_id->HrefValue = "";
        $this->status_id->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // tanggal_laporan
        $this->tanggal_laporan->LinkCustomAttributes = "";
        $this->tanggal_laporan->HrefValue = "";
        $this->tanggal_laporan->TooltipValue = "";

        // tanggal_diproses
        $this->tanggal_diproses->LinkCustomAttributes = "";
        $this->tanggal_diproses->HrefValue = "";
        $this->tanggal_diproses->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // lokasi
        $this->lokasi->EditAttrs["class"] = "form-control";
        $this->lokasi->EditCustomAttributes = "";
        $this->lokasi->EditValue = $this->lokasi->CurrentValue;
        $this->lokasi->PlaceHolder = RemoveHtml($this->lokasi->caption());

        // gambar_terlapor
        $this->gambar_terlapor->EditAttrs["class"] = "form-control";
        $this->gambar_terlapor->EditCustomAttributes = "";
        if (!EmptyValue($this->gambar_terlapor->Upload->DbValue)) {
            $this->gambar_terlapor->ImageAlt = $this->gambar_terlapor->alt();
            $this->gambar_terlapor->EditValue = $this->gambar_terlapor->Upload->DbValue;
        } else {
            $this->gambar_terlapor->EditValue = "";
        }
        if (!EmptyValue($this->gambar_terlapor->CurrentValue)) {
            $this->gambar_terlapor->Upload->FileName = $this->gambar_terlapor->CurrentValue;
        }

        // gambar_terproses
        $this->gambar_terproses->EditAttrs["class"] = "form-control";
        $this->gambar_terproses->EditCustomAttributes = "";
        if (!EmptyValue($this->gambar_terproses->Upload->DbValue)) {
            $this->gambar_terproses->ImageAlt = $this->gambar_terproses->alt();
            $this->gambar_terproses->EditValue = $this->gambar_terproses->Upload->DbValue;
        } else {
            $this->gambar_terproses->EditValue = "";
        }
        if (!EmptyValue($this->gambar_terproses->CurrentValue)) {
            $this->gambar_terproses->Upload->FileName = $this->gambar_terproses->CurrentValue;
        }

        // status_id
        $this->status_id->EditCustomAttributes = "";
        $this->status_id->PlaceHolder = RemoveHtml($this->status_id->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // tanggal_laporan
        $this->tanggal_laporan->EditAttrs["class"] = "form-control";
        $this->tanggal_laporan->EditCustomAttributes = "";
        $this->tanggal_laporan->EditValue = FormatDateTime($this->tanggal_laporan->CurrentValue, 8);
        $this->tanggal_laporan->PlaceHolder = RemoveHtml($this->tanggal_laporan->caption());

        // tanggal_diproses
        $this->tanggal_diproses->EditAttrs["class"] = "form-control";
        $this->tanggal_diproses->EditCustomAttributes = "";
        $this->tanggal_diproses->EditValue = FormatDateTime($this->tanggal_diproses->CurrentValue, 8);
        $this->tanggal_diproses->PlaceHolder = RemoveHtml($this->tanggal_diproses->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->lokasi);
                    $doc->exportCaption($this->gambar_terlapor);
                    $doc->exportCaption($this->gambar_terproses);
                    $doc->exportCaption($this->status_id);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->tanggal_laporan);
                    $doc->exportCaption($this->tanggal_diproses);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->lokasi);
                    $doc->exportCaption($this->status_id);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->tanggal_laporan);
                    $doc->exportCaption($this->tanggal_diproses);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->lokasi);
                        $doc->exportField($this->gambar_terlapor);
                        $doc->exportField($this->gambar_terproses);
                        $doc->exportField($this->status_id);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->tanggal_laporan);
                        $doc->exportField($this->tanggal_diproses);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->lokasi);
                        $doc->exportField($this->status_id);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->tanggal_laporan);
                        $doc->exportField($this->tanggal_diproses);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'gambar_terlapor') {
            $fldName = "gambar_terlapor";
            $fileNameFld = "gambar_terlapor";
        } elseif ($fldparm == 'gambar_terproses') {
            $fldName = "gambar_terproses";
            $fileNameFld = "gambar_terproses";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
