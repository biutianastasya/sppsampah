<?php

namespace PHPMaker2021\sppsampah;

/**
 * Advanced Security class
 */
class AdvancedSecurity
{
    public $UserLevel = []; // All User Levels
    public $UserLevelPriv = []; // All User Level permissions
    public $UserLevelID = []; // User Level ID array
    public $UserID = []; // User ID array
    public $CurrentUserLevelID = -2; // User Level (Anonymous by default)
    public $CurrentUserLevel; // Permissions
    public $CurrentUserID;
    public $CurrentParentUserID;
    private $isLoggedIn = false;
    private $isSysAdmin = false;
    private $userName;

    // Constructor
    public function __construct()
    {
        global $Security;
        $Security = $this;
        // Init User Level
        if ($this->isLoggedIn()) {
            $this->CurrentUserLevelID = $this->sessionUserLevelID();
            $this->setUserLevelID($this->CurrentUserLevelID);
        } else { // Anonymous user
            $this->CurrentUserLevelID = -2;
            $this->UserLevelID[] = $this->CurrentUserLevelID;
        }
        $_SESSION[SESSION_USER_LEVEL_LIST] = $this->userLevelList();

        // Init User ID
        $this->CurrentUserID = $this->sessionUserID();
        $this->CurrentParentUserID = $this->sessionParentUserID();

        // Load user level
        $this->loadUserLevel();
    }

    // Get session User ID
    protected function sessionUserID()
    {
        return isset($_SESSION[SESSION_USER_ID]) ? strval(Session(SESSION_USER_ID)) : $this->CurrentUserID;
    }

    // Set session User ID
    protected function setSessionUserID($v)
    {
        $this->CurrentUserID = trim(strval($v));
        $_SESSION[SESSION_USER_ID] = $this->CurrentUserID;
    }

    // Get session Parent User ID
    protected function sessionParentUserID()
    {
        return isset($_SESSION[SESSION_PARENT_USER_ID]) ? strval(Session(SESSION_PARENT_USER_ID)) : $this->CurrentParentUserID;
    }

    // Set session Parent User ID
    protected function setSessionParentUserID($v)
    {
        $this->CurrentParentUserID = trim(strval($v));
        $_SESSION[SESSION_PARENT_USER_ID] = $this->CurrentParentUserID;
    }

    // Get session User Level ID
    protected function sessionUserLevelID()
    {
        return $_SESSION[SESSION_USER_LEVEL_ID] ?? $this->CurrentUserLevelID;
    }

    // Set session User Level ID
    protected function setSessionUserLevelID($v)
    {
        $this->CurrentUserLevelID = $v;
        $_SESSION[SESSION_USER_LEVEL_ID] = $this->CurrentUserLevelID;
        $this->setUserLevelID($v);
    }

    // Set User Level ID to array
    private function setUserLevelID($v)
    {
        $ids = is_array($v) ? $v : explode(Config("MULTIPLE_OPTION_SEPARATOR"), strval($v));
        $this->UserLevelID = [];
        foreach ($ids as $id) {
            if ((int)$id >= -2) {
                $this->UserLevelID[] = (int)$id;
            }
        }
    }

    // Check if User Level ID in array
    public function hasUserLevelID($v)
    {
        $ids = is_array($v) ? $v : explode(Config("MULTIPLE_OPTION_SEPARATOR"), strval($v));
        foreach ($ids as $id) {
            if (in_array((int)$id, $this->UserLevelID)) {
                return true;
            }
        }
        return false;
    }

    // Get session User Level
    protected function sessionUserLevel()
    {
        return isset($_SESSION[SESSION_USER_LEVEL]) ? (int)$_SESSION[SESSION_USER_LEVEL] : $this->CurrentUserLevel;
    }

    // Set session User Level
    protected function setSessionUserLevel($v)
    {
        $this->CurrentUserLevel = $v;
        $_SESSION[SESSION_USER_LEVEL] = $this->CurrentUserLevel;
    }

    // Get current user name
    public function getCurrentUserName()
    {
        return isset($_SESSION[SESSION_USER_NAME]) ? strval($_SESSION[SESSION_USER_NAME]) : $this->userName;
    }

    // Set current user name
    public function setCurrentUserName($v)
    {
        $this->userName = $v;
        $_SESSION[SESSION_USER_NAME] = $this->userName;
    }

    // Get current user name (alias)
    public function currentUserName()
    {
        return $this->getCurrentUserName();
    }

    // Current User ID
    public function currentUserID()
    {
        return $this->CurrentUserID;
    }

    // Current Parent User ID
    public function currentParentUserID()
    {
        return $this->CurrentParentUserID;
    }

    // Current User Level ID
    public function currentUserLevelID()
    {
        return $this->CurrentUserLevelID;
    }

    // Current User Level value
    public function currentUserLevel()
    {
        return $this->CurrentUserLevel;
    }

    // Get JWT Token
    public function createJwt($minExpiry = 0)
    {
        return CreateJwt(
            $this->currentUserName(),
            $this->sessionUserID(),
            $this->sessionParentUserID(),
            $this->sessionUserLevelID(),
            $minExpiry
        );
    }

    // Can add
    public function canAdd()
    {
        return (($this->CurrentUserLevel & ALLOW_ADD) == ALLOW_ADD);
    }

    // Set can add
    public function setCanAdd($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_ADD;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_ADD;
        }
    }

    // Can delete
    public function canDelete()
    {
        return (($this->CurrentUserLevel & ALLOW_DELETE) == ALLOW_DELETE);
    }

    // Set can delete
    public function setCanDelete($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_DELETE;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_DELETE;
        }
    }

    // Can edit
    public function canEdit()
    {
        return (($this->CurrentUserLevel & ALLOW_EDIT) == ALLOW_EDIT);
    }

    // Set can edit
    public function setCanEdit($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_EDIT;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_EDIT;
        }
    }

    // Can view
    public function canView()
    {
        return (($this->CurrentUserLevel & ALLOW_VIEW) == ALLOW_VIEW);
    }

    // Set can view
    public function setCanView($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_VIEW;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_VIEW;
        }
    }

    // Can list
    public function canList()
    {
        return (($this->CurrentUserLevel & ALLOW_LIST) == ALLOW_LIST);
    }

    // Set can list
    public function setCanList($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_LIST;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_LIST;
        }
    }

    // Can report
    public function canReport()
    {
        return (($this->CurrentUserLevel & ALLOW_REPORT) == ALLOW_REPORT);
    }

    // Set can report
    public function setCanReport($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_REPORT;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_REPORT;
        }
    }

    // Can search
    public function canSearch()
    {
        return (($this->CurrentUserLevel & ALLOW_SEARCH) == ALLOW_SEARCH);
    }

    // Set can search
    public function setCanSearch($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_SEARCH;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_SEARCH;
        }
    }

    // Can admin
    public function canAdmin()
    {
        return (($this->CurrentUserLevel & ALLOW_ADMIN) == ALLOW_ADMIN);
    }

    // Set can admin
    public function setCanAdmin($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_ADMIN;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_ADMIN;
        }
    }

    // Can import
    public function canImport()
    {
        return (($this->CurrentUserLevel & ALLOW_IMPORT) == ALLOW_IMPORT);
    }

    // Set can import
    public function setCanImport($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_IMPORT;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_IMPORT;
        }
    }

    // Can lookup
    public function canLookup()
    {
        return (($this->CurrentUserLevel & ALLOW_LOOKUP) == ALLOW_LOOKUP);
    }

    // Set can lookup
    public function setCanLookup($b)
    {
        if ($b) {
            $this->CurrentUserLevel |= ALLOW_LOOKUP;
        } else {
            $this->CurrentUserLevel &= ~ALLOW_LOOKUP;
        }
    }

    // Last URL
    public function lastUrl()
    {
        return ReadCookie("LastUrl");
    }

    // Save last URL
    public function saveLastUrl()
    {
        $s = CurrentUrl();
        $q = ServerVar("QUERY_STRING");
        if ($q != "") {
            $s .= "?" . $q;
        }
        if ($this->lastUrl() == $s) {
            $s = "";
        }
        if (!preg_match('/[?&]modal=1(&|$)/', $s)) { // Query string does not contain "modal=1"
            WriteCookie("LastUrl", $s);
        }
    }

    // Auto login
    public function autoLogin()
    {
        $autologin = false;
        if (!$autologin && ReadCookie("AutoLogin") == "autologin") {
            $usr = Decrypt(ReadCookie("Username"));
            $pwd = Decrypt(ReadCookie("Password"));
            if ($usr !== false && $pwd !== false) {
                $autologin = $this->validateUser($usr, $pwd, true);
            }
        }
        if (!$autologin && Config("ALLOW_LOGIN_BY_URL") && Get("username") !== null) {
            $usr = RemoveXss(Get("username"));
            $pwd = RemoveXss(Get("password"));
            $autologin = $this->validateUser($usr, $pwd, true);
        }
        if (!$autologin && Config("ALLOW_LOGIN_BY_SESSION") && isset($_SESSION[PROJECT_NAME . "_Username"])) {
            $usr = Session(PROJECT_NAME . "_Username");
            $pwd = Session(PROJECT_NAME . "_Password");
            $autologin = $this->validateUser($usr, $pwd, true);
        }
        return $autologin;
    }

    // Login user
    public function loginUser($userName = null, $userID = null, $parentUserID = null, $userLevel = null)
    {
        if ($userName != null) {
            $this->setCurrentUserName($userName);
            $this->isLoggedIn = true;
            $_SESSION[SESSION_STATUS] = "login";
            $this->isSysAdmin = $this->validateSysAdmin($userName);
        }
        if ($userID != null) {
            $this->setSessionUserID($userID);
        }
        if ($parentUserID != null) {
            $this->setSessionParentUserID($parentUserID);
        }
        if ($userLevel != null) {
            $this->setSessionUserLevelID($userLevel);
            $this->setupUserLevel();
        }
    }

    // Logout user
    public function logoutUser()
    {
        $this->isLoggedIn = false;
        $_SESSION[SESSION_STATUS] = "";
        $this->setCurrentUserName("");
        $this->setSessionUserID("");
        $this->setSessionParentUserID("");
        $this->setSessionUserLevelID(-2);
        $this->setupUserLevel();
    }

    // Validate user
    public function validateUser(&$usr, &$pwd, $autologin, $provider = "")
    {
        global $Language, $UserProfile;
        global $UserTable;
        $valid = false;
        $customValid = false;
        $providerValid = false;

        // OAuth provider
        if ($provider != "") {
            $authConfig = Config("AUTH_CONFIG");
            $providers = $authConfig["providers"];
            if (array_key_exists($provider, $providers) && $providers[$provider]["enabled"]) {
                try {
                    $UserProfile->Provider = $provider;
                    // Note: callback url is login?provider=xxx
                    if (!array_key_exists("callback", $authConfig)) {
                        $authConfig["callback"] = FullUrl("login?provider=" . $provider, "auth");
                    }
                    $hybridauth = new \Hybridauth\Hybridauth($authConfig);
                    $UserProfile->Auth = $hybridauth;
                    $adapter = $hybridauth->authenticate($provider); // Authenticate with the selected provider
                    $profile = $adapter->getUserProfile();
                    $UserProfile->assign($profile); // Save profile
                    $usr = $profile->email;
                    $providerValid = true;
                } catch (\Throwable $e) {
                    if (Config("DEBUG")) {
                        throw new \Exception($e->getMessage());
                    }
                    return false;
                }
            } else {
                if (Config("DEBUG")) {
                    throw new \Exception("Provider for " . $provider . " not found or not enabled.");
                }
                return false;
            }
        }

        // Call User Custom Validate event
        if (Config("USE_CUSTOM_LOGIN")) {
            $customValid = $this->userCustomValidate($usr, $pwd);
        }

        // Handle provider login as custom login
        if ($providerValid) {
            $customValid = true;
        }
        if ($customValid) {
            //$_SESSION[SESSION_STATUS] = "login"; // To be setup below
            $this->setCurrentUserName($usr); // Load user name
        }

        // Check other users
        if (!$valid) {
            $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);

            // User table object
            $UserTable = Container("usertable");

            // Set up filter (WHERE Clause)
            $sql = $UserTable->getSql($filter);
            if ($row = Conn($UserTable->Dbid)->fetchAssoc($sql)) {
                $valid = $customValid || ComparePassword(GetUserInfo(Config("LOGIN_PASSWORD_FIELD_NAME"), $row), $pwd);
                if ($valid) {
                    $this->isLoggedIn = true;
                    $_SESSION[SESSION_STATUS] = "login";
                    $this->isSysAdmin = false;
                    $_SESSION[SESSION_SYS_ADMIN] = 0; // Non System Administrator
                    $this->setCurrentUserName(GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row)); // Load user name
                    $this->setSessionUserID(GetUserInfo(Config("USER_ID_FIELD_NAME"), $row)); // Load User ID
                    if (GetUserInfo(Config("USER_LEVEL_FIELD_NAME"), $row) === null) {
                        $this->setSessionUserLevelID(0);
                    } else {
                        $this->setSessionUserLevelID(GetUserInfo(Config("USER_LEVEL_FIELD_NAME"), $row)); // Load User Level
                    }
                    $this->setupUserLevel();

                    // Call User Validated event
                    $UserProfile->assign($row);
                    $UserProfile->delete(Config("LOGIN_PASSWORD_FIELD_NAME")); // Delete password
                    $valid = $this->userValidated($row) !== false; // For backward compatibility
                }
            } else { // User not found in user table
                if ($customValid) { // Grant default permissions
                    $this->setSessionUserID($usr); // User name as User ID
                    $this->setSessionUserLevelID(-2); // Anonymous User Level
                    $this->setupUserLevel();
                    $row = null;
                    $customValid = $this->userValidated($row) !== false;
                }
            }
        }
        $UserProfile->save();
        if ($customValid) {
            return $customValid;
        }
        if (!$valid && !IsPasswordExpired()) {
            $this->isLoggedIn = false;
            $_SESSION[SESSION_STATUS] = ""; // Clear login status
        }
        return $valid;
    }

    // Valdiate System Administrator
    private function validateSysAdmin($userName, $password = "", $checkUserNameOnly = true)
    {
        $adminUserName = Config("ADMIN_USER_NAME");
        $adminPassword = Config("ADMIN_PASSWORD");
        if (Config("ENCRYPTION_ENABLED")) {
            try {
                $adminUserName = PhpDecrypt(Config("ADMIN_USER_NAME"), Config("ENCRYPTION_KEY"));
                $adminPassword = PhpDecrypt(Config("ADMIN_PASSWORD"), Config("ENCRYPTION_KEY"));
            } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $e) {
                $adminUserName = Config("ADMIN_USER_NAME");
                $adminPassword = Config("ADMIN_PASSWORD");
            }
        }
        if (Config("CASE_SENSITIVE_PASSWORD")) {
            return !$checkUserNameOnly && $adminUserName === $userName && $adminPassword === $password ||
                $checkUserNameOnly && $adminUserName === $userName;
        } else {
            return !$checkUserNameOnly && SameText($adminUserName, $userName) && SameText($adminPassword, $password) ||
                $checkUserNameOnly && SameText($adminUserName, $userName);
        }
    }

    // Static User Level security
    public function setupUserLevel()
    {
        // Load user level from user level settings
        global $USER_LEVELS, $USER_LEVEL_PRIVS;
        $this->UserLevel = $USER_LEVELS;
        $this->UserLevelPriv = $USER_LEVEL_PRIVS;

        // User Level loaded event
        $this->userLevelLoaded();

        // Check permissions
        $this->checkPermissions();

        // Save the User Level to Session variable
        $this->saveUserLevel();
    }

    // Get all User Level settings from database
    public function setupUserLevelEx()
    {
        return false;
    }

    // Check import/lookup permissions
    protected function checkPermissions()
    {
        if (is_array($this->UserLevelPriv)) {
            foreach ($this->UserLevelPriv as &$row) {
                $priv = &$row[2];
                if (is_numeric($priv)) {
                    if (($priv & ALLOW_IMPORT) != ALLOW_IMPORT && ($priv & ALLOW_ADMIN) == ALLOW_ADMIN) {
                        $priv = $priv | ALLOW_IMPORT; // Import permission not setup, use Admin
                    }
                    if (($priv & ALLOW_LOOKUP) != ALLOW_LOOKUP && ($priv & ALLOW_LIST) == ALLOW_LIST) {
                        $priv = $priv | ALLOW_LOOKUP; // Lookup permission not setup, use List
                    }
                }
            }
        }
    }

    // Add user permission
    protected function addUserPermissionEx($userLevelName, $tableName, $userPermission)
    {
        // Get User Level ID from user name
        $userLevelID = "";
        if (is_array($this->UserLevel)) {
            foreach ($this->UserLevel as $row) {
                list($levelid, $name) = $row;
                if (SameText($userLevelName, $name)) {
                    $userLevelID = $levelid;
                    break;
                }
            }
        }
        if (is_array($this->UserLevelPriv) && $userLevelID != "") {
            $cnt = count($this->UserLevelPriv);
            for ($i = 0; $i < $cnt; $i++) {
                list($table, $levelid, $priv) = $this->UserLevelPriv[$i];
                if (SameText($table, PROJECT_ID . $tableName) && SameString($levelid, $userLevelID)) {
                    $this->UserLevelPriv[$i][2] = $priv | $userPermission; // Add permission
                    break;
                }
            }
        }
    }

    // Add user permission
    public function addUserPermission($userLevelName, $tableName, $userPermission)
    {
        $arUserLevelName = is_array($userLevelName) ? $userLevelName : [$userLevelName];
        $arTableName = is_array($tableName) ? $tableName : [$tableName];
        foreach ($arUserLevelName as $userLevelName) {
            foreach ($arTableName as $tableName) {
                $this->addUserPermissionEx($userLevelName, $tableName, $userPermission);
            }
        }
    }

    // Delete user permission
    protected function deleteUserPermissionEx($userLevelName, $tableName, $userPermission)
    {
        // Get User Level ID from user name
        $userLevelID = "";
        if (is_array($this->UserLevel)) {
            foreach ($this->UserLevel as $row) {
                list($levelid, $name) = $row;
                if (SameText($userLevelName, $name)) {
                    $userLevelID = $levelid;
                    break;
                }
            }
        }
        if (is_array($this->UserLevelPriv) && $userLevelID != "") {
            $cnt = count($this->UserLevelPriv);
            for ($i = 0; $i < $cnt; $i++) {
                list($table, $levelid, $priv) = $this->UserLevelPriv[$i];
                if (SameText($table, PROJECT_ID . $tableName) && SameString($levelid, $userLevelID)) {
                    $this->UserLevelPriv[$i][2] = $priv & ~$userPermission; // Remove permission
                    break;
                }
            }
        }
    }

    // Delete user permission
    public function deleteUserPermission($userLevelName, $tableName, $userPermission)
    {
        $arUserLevelName = is_array($userLevelName) ? $userLevelName : [$userLevelName];
        $arTableName = is_array($tableName) ? $tableName : [$tableName];
        foreach ($arUserLevelName as $userLevelName) {
            foreach ($arTableName as $tableName) {
                $this->deleteUserPermissionEx($userLevelName, $tableName, $userPermission);
            }
        }
    }

    // Load table permissions
    public function loadTablePermissions($tblVar)
    {
        $tblName = GetTableName($tblVar);
        if ($this->isLoggedIn() && method_exists($this, "tablePermissionLoading")) {
            $this->tablePermissionLoading();
        }
        $this->loadCurrentUserLevel(PROJECT_ID . $tblName);
        if ($this->isLoggedIn() && method_exists($this, "tablePermissionLoaded")) {
            $this->tablePermissionLoaded();
        }
        if ($this->isLoggedIn()) {
            if (method_exists($this, "userIDLoading")) {
                $this->userIDLoading();
            }
            if (method_exists($this, "loadUserID")) {
                $this->loadUserID();
            }
            if (method_exists($this, "userIDLoaded")) {
                $this->userIDLoaded();
            }
        }
    }

    // Load current User Level
    public function loadCurrentUserLevel($table)
    {
        // Load again if user level list changed
        if (Session(SESSION_USER_LEVEL_LIST_LOADED) != "" && Session(SESSION_USER_LEVEL_LIST_LOADED) != Session(SESSION_USER_LEVEL_LIST)) {
            $_SESSION[SESSION_AR_USER_LEVEL_PRIV] = "";
        }
        $this->loadUserLevel();
        $this->setSessionUserLevel($this->currentUserLevelPriv($table));
    }

    // Get current user privilege
    protected function currentUserLevelPriv($tableName)
    {
        if ($this->isLoggedIn()) {
            $priv = 0;
            foreach ($this->UserLevelID as $userLevelID) {
                $priv |= $this->getUserLevelPrivEx($tableName, $userLevelID);
            }
            return $priv;
        } else { // Anonymous
            return $this->getUserLevelPrivEx($tableName, -2);
        }
    }

    // Get User Level ID by User Level name
    public function getUserLevelID($userLevelName)
    {
        global $Language;
        if (SameString($userLevelName, "Anonymous")) {
            return -2;
        } elseif ($Language && SameString($userLevelName, $Language->phrase("UserAnonymous"))) {
            return -2;
        } elseif (SameString($userLevelName, "Administrator")) {
            return -1;
        } elseif ($Language && SameString($userLevelName, $Language->phrase("UserAdministrator"))) {
            return -1;
        } elseif (SameString($userLevelName, "Default")) {
            return 0;
        } elseif ($Language && SameString($userLevelName, $Language->phrase("UserDefault"))) {
            return 0;
        } elseif ($userLevelName != "") {
            if (is_array($this->UserLevel)) {
                foreach ($this->UserLevel as $row) {
                    list($levelid, $name) = $row;
                    if (SameString($name, $userLevelName)) {
                        return $levelid;
                    }
                }
            }
        }
        return -2; // Anonymous
    }

    // Add User Level by name
    public function addUserLevel($userLevelName)
    {
        if (strval($userLevelName) == "") {
            return;
        }
        $userLevelID = $this->getUserLevelID($userLevelName);
        $this->addUserLevelID($userLevelID);
    }

    // Add User Level by ID
    public function addUserLevelID($userLevelID)
    {
        if (!is_numeric($userLevelID)) {
            return;
        }
        if ($userLevelID < -1) {
            return;
        }
        if (!in_array($userLevelID, $this->UserLevelID)) {
            $this->UserLevelID[] = $userLevelID;
            $_SESSION[SESSION_USER_LEVEL_LIST] = $this->userLevelList(); // Update session variable
        }
    }

    // Delete User Level by name
    public function deleteUserLevel($userLevelName)
    {
        if (strval($userLevelName) == "") {
            return;
        }
        $userLevelID = $this->getUserLevelID($userLevelName);
        $this->deleteUserLevelID($userLevelID);
    }

    // Delete User Level by ID
    public function deleteUserLevelID($userLevelID)
    {
        if (!is_numeric($userLevelID)) {
            return;
        }
        if ($userLevelID < -1) {
            return;
        }
        $cnt = count($this->UserLevelID);
        for ($i = 0; $i < $cnt; $i++) {
            if ($this->UserLevelID[$i] == $userLevelID) {
                unset($this->UserLevelID[$i]);
                $_SESSION[SESSION_USER_LEVEL_LIST] = $this->userLevelList(); // Update session variable
                break;
            }
        }
    }

    // User Level list
    public function userLevelList()
    {
        return implode(", ", $this->UserLevelID);
    }

    // User level ID exists
    public function userLevelIDExists($id)
    {
        if (is_array($this->UserLevel)) {
            foreach ($this->UserLevel as $row) {
                list($levelid, $name) = $row;
                if (SameString($levelid, $id)) {
                    return true;
                }
            }
        }
        return false;
    }

    // User Level name list
    public function userLevelNameList()
    {
        $list = "";
        foreach ($this->UserLevelID as $userLevelID) {
            if ($list != "") {
                $list .= ", ";
            }
            $list .= QuotedValue($this->getUserLevelName($userLevelID), DATATYPE_STRING, Config("USER_LEVEL_DBID"));
        }
        return $list;
    }

    // Get user privilege based on table name and User Level
    public function getUserLevelPrivEx($tableName, $userLevelID)
    {
        $ids = explode(Config("MULTIPLE_OPTION_SEPARATOR"), strval($userLevelID));
        $userPriv = 0;
        foreach ($ids as $id) {
            if (strval($id) == "-1") { // System Administrator
                return ALLOW_ALL;
            } elseif ((int)$id >= 0 || (int)$id == -2) {
                if (is_array($this->UserLevelPriv)) {
                    foreach ($this->UserLevelPriv as $row) {
                        list($table, $levelid, $priv) = $row;
                        if (SameText($table, $tableName) && SameText($levelid, $id)) {
                            if (is_numeric($priv)) {
                                $userPriv |= (int)$priv;
                            }
                        }
                    }
                }
            }
        }
        return $userPriv;
    }

    // Get current User Level name
    public function currentUserLevelName()
    {
        return $this->getUserLevelName($this->currentUserLevelID());
    }

    // Get User Level name based on User Level
    public function getUserLevelName($userLevelID, $lang = true)
    {
        global $Language;
        if (strval($userLevelID) == "-2") {
            return ($lang) ? $Language->phrase("UserAnonymous") : "Anonymous";
        } elseif (strval($userLevelID) == "-1") {
            return ($lang) ? $Language->phrase("UserAdministrator") : "Administrator";
        } elseif (strval($userLevelID) == "0") {
            return ($lang) ? $Language->phrase("UserDefault") : "Default";
        } elseif ($userLevelID > 0) {
            if (is_array($this->UserLevel)) {
                foreach ($this->UserLevel as $row) {
                    list($levelid, $name) = $row;
                    if (SameString($levelid, $userLevelID)) {
                        $userLevelName = "";
                        if ($lang) {
                            $userLevelName = $Language->phrase($name);
                        }
                        return ($userLevelName != "") ? $userLevelName : $name;
                    }
                }
            }
        }
        return "";
    }

    // Display all the User Level settings (for debug only)
    public function showUserLevelInfo()
    {
        Write("<pre>");
        Write(print_r($this->UserLevel, true));
        Write(print_r($this->UserLevelPriv, true));
        Write("</pre>");
        Write("<p>Current User Level ID = " . $this->currentUserLevelID() . "</p>");
        Write("<p>Current User Level ID List = " . $this->userLevelList() . "</p>");
    }

    // Check privilege for List page (for menu items)
    public function allowList($tableName)
    {
        return ($this->currentUserLevelPriv($tableName) & ALLOW_LIST);
    }

    // Check privilege for View page (for Allow-View / Detail-View)
    public function allowView($tableName)
    {
        return ($this->currentUserLevelPriv($tableName) & ALLOW_VIEW);
    }

    // Check privilege for Add page (for Allow-Add / Detail-Add)
    public function allowAdd($tableName)
    {
        return ($this->currentUserLevelPriv($tableName) & ALLOW_ADD);
    }

    // Check privilege for Edit page (for Detail-Edit)
    public function allowEdit($tableName)
    {
        return ($this->currentUserLevelPriv($tableName) & ALLOW_EDIT);
    }

    // Check privilege for lookup
    public function allowLookup($tableName)
    {
        return ($this->currentUserLevelPriv($tableName) & ALLOW_LOOKUP);
    }

    // Check if user password expired
    public function isPasswordExpired()
    {
        return (Session(SESSION_STATUS) == "passwordexpired");
    }

    // Set session password expired
    public function setSessionPasswordExpired()
    {
        $_SESSION[SESSION_STATUS] = "passwordexpired";
    }

    // Set login status
    public function setLoginStatus($status = "")
    {
        $_SESSION[SESSION_STATUS] = $status;
    }

    // Check if user password reset
    public function isPasswordReset()
    {
        return (Session(SESSION_STATUS) == "passwordreset");
    }

    // Check if user is logging in (after changing password)
    public function isLoggingIn()
    {
        return (Session(SESSION_STATUS) == "loggingin");
    }

    // Check if user is logged in
    public function isLoggedIn()
    {
        return ($this->isLoggedIn || Session(SESSION_STATUS) == "login");
    }

    // Check if user is system administrator
    public function isSysAdmin()
    {
        return ($this->isSysAdmin || Session(SESSION_SYS_ADMIN) === 1);
    }

    // Check if user is administrator
    public function isAdmin()
    {
        $isAdmin = $this->isSysAdmin();
        if (!$isAdmin) {
            $isAdmin = $this->CurrentUserLevelID == -1 || $this->hasUserLevelID(-1) || $this->canAdmin();
        }
        if (!$isAdmin) {
            $isAdmin = $this->CurrentUserID == -1 || in_array(-1, $this->UserID);
        }
        return $isAdmin;
    }

    // Save User Level to Session
    public function saveUserLevel()
    {
        $_SESSION[SESSION_AR_USER_LEVEL] = $this->UserLevel;
        $_SESSION[SESSION_AR_USER_LEVEL_PRIV] = $this->UserLevelPriv;
    }

    // Load User Level from Session
    public function loadUserLevel()
    {
        if (empty(Session(SESSION_AR_USER_LEVEL)) || empty(Session(SESSION_AR_USER_LEVEL_PRIV))) {
            $this->setupUserLevel();
            $this->saveUserLevel();
        } else {
            $this->UserLevel = Session(SESSION_AR_USER_LEVEL);
            $this->UserLevelPriv = Session(SESSION_AR_USER_LEVEL_PRIV);
        }
    }

    // Get current user info
    public function currentUserInfo($fldname)
    {
        global $UserTable;
        $info = null;
        if (Config("USER_TABLE") && !$this->isSysAdmin()) {
            $filter = GetUserFilter(Config("USER_ID_FIELD_NAME"), $this->CurrentUserID);
            if ($filter != "") {
                $sql = $UserTable->getSql($filter);
                if ($row = ExecuteRow($sql, $UserTable->Dbid)) {
                    $info = GetUserInfo($fldname, $row);
                }
            }
        }
        return $info;
    }

    // Get User ID by user name
    public function getUserIDByUserName($userName)
    {
        global $UserTable;
        if (strval($userName) != "") {
            $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $userName);
            $sql = $UserTable->getSql($filter);
            if ($row = Conn($UserTable->Dbid)->fetchAssoc($sql)) {
                $userID = GetUserInfo(Config("USER_ID_FIELD_NAME"), $row);
                return $userID;
            }
        }
        return "";
    }

    // Load User ID
    public function loadUserID()
    {
        global $UserTable;
        $this->UserID = [];
        if (strval($this->CurrentUserID) == "") {
            // Handle empty User ID here
        } elseif ($this->CurrentUserID != "-1") {
            // Get first level
            $this->addUserID($this->CurrentUserID);
            $UserTable = Container("usertable");
            $filter = "";
            if (method_exists($UserTable, "getUserIDFilter")) {
                $filter = $UserTable->getUserIDFilter($this->CurrentUserID);
            }
            $sql = $UserTable->getSql($filter);
            $rows = Conn($UserTable->Dbid)->fetchAll($sql);
            foreach ($rows as $row) {
                $this->addUserID(GetUserInfo(Config("USER_ID_FIELD_NAME"), $row));
            }
        }
    }

    // Add user name
    public function addUserName($userName)
    {
        $this->addUserID($this->getUserIDByUserName($userName));
    }

    // Add User ID
    public function addUserID($userId)
    {
        if (strval($userId) == "") {
            return;
        }
        if (!is_numeric($userId)) {
            return;
        }
        $userId = trim($userId);
        if (!in_array($userId, $this->UserID)) {
            $this->UserID[] = $userId;
        }
    }

    // Delete user name
    public function deleteUserName($userName)
    {
        $this->deleteUserID($this->getUserIDByUserName($userName));
    }

    // Delete User ID
    public function deleteUserID($userId)
    {
        if (strval($userId) == "") {
            return;
        }
        if (!is_numeric($userId)) {
            return;
        }
        $cnt = count($this->UserID);
        for ($i = 0; $i < $cnt; $i++) {
            if (SameString($this->UserID[$i], $userId)) {
                unset($this->UserID[$i]);
                break;
            }
        }
    }

    // User ID list
    public function userIDList()
    {
        return implode(", ", array_map(function ($userId) {
            return QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID"));
        }, $this->UserID));
    }

    // List of allowed User IDs for this user
    public function isValidUserID($userId)
    {
        return in_array(trim($userId), $this->UserID);
    }

    // UserID Loading event
    public function userIdLoading()
    {
        //Log("UserID Loading: " . $this->currentUserID());
    }

    // UserID Loaded event
    public function userIdLoaded()
    {
        //Log("UserID Loaded: " . $this->userIDList());
    }

    // User Level Loaded event
    public function userLevelLoaded()
    {
        //$this->AddUserPermission(<UserLevelName>, <TableName>, <UserPermission>);
        //$this->DeleteUserPermission(<UserLevelName>, <TableName>, <UserPermission>);
    }

    // Table Permission Loading event
    public function tablePermissionLoading()
    {
        //Log("Table Permission Loading: " . $this->CurrentUserLevelID);
    }

    // Table Permission Loaded event
    public function tablePermissionLoaded()
    {
        //Log("Table Permission Loaded: " . $this->CurrentUserLevel);
    }

    // User Custom Validate event
    public function userCustomValidate(&$usr, &$pwd)
    {
        // Enter your custom code to validate user, return true if valid.
        return false;
    }

    // User Validated event
    public function userValidated(&$rs)
    {
        // Example:
        //$_SESSION['UserEmail'] = $rs['Email'];
    }

    // User PasswordExpired event
    public function userPasswordExpired(&$rs)
    {
        //Log("User_PasswordExpired");
    }
}
