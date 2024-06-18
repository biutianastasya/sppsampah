<?php

namespace PHPMaker2021\sppsampah;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(1, "mi_report", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "reportlist", -1, "", AllowListMenu('{C5AED618-EE40-41D5-A67D-FF429990F678}report'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mci_Administrasi", $MenuLanguage->MenuPhrase("4", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(2, "mi_status", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "statuslist", 4, "", AllowListMenu('{C5AED618-EE40-41D5-A67D-FF429990F678}status'), false, false, "", "", false);
$sideMenu->addMenuItem(3, "mi_users", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "userslist", 4, "", AllowListMenu('{C5AED618-EE40-41D5-A67D-FF429990F678}users'), false, false, "", "", false);
echo $sideMenu->toScript();
