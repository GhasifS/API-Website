<?php
//Version 3.2
#311F9A7C210B16935E195B036966BBEC
$steamauth['apikey'] = "95B4A64C1521B1D7CBF7B7D55B2B4296"; // Your Steam WebAPI-Key found at https://steamcommunity.com/dev/apikey
$steamauth['domainname'] = "localhost"; // The main URL of your website displayed in the login page
$steamauth['logoutpage'] = "index.php"; // Page to redirect to after a successfull logout (from the directory the SteamAuth-folder is located in) - NO slash at the beginning!
$steamauth['loginpage'] = "index.php"; // Page to redirect to after a successfull login (from the directory the SteamAuth-folder is located in) - NO slash at the beginning!

// System stuff
if (empty($steamauth['apikey'])) {die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>SteamAuth:<br>Please supply an API-Key!<br>Find this in steamauth/SteamConfig.php, Find the '<b>\$steamauth['apikey']</b>' Array. </div>");}
if (empty($steamauth['domainname'])) {$steamauth['domainname'] = $_SERVER['SERVER_NAME'];}
if (empty($steamauth['logoutpage'])) {$steamauth['logoutpage'] = $_SERVER['PHP_SELF'];}
if (empty($steamauth['loginpage'])) {$steamauth['loginpage'] = $_SERVER['PHP_SELF'];}
?>
