<?php
//header() sends a raw HTTP header to the browser
function authenticate() {
    echo $_SERVER["PHP_AUTH_USER"] . "<BR>";
    
    if ((isset($_SERVER["PHP_AUTH_USER"]) && ($_SERVER['PHP_AUTH_USER'] == 'client') && 
        isset($_SERVER['PHP_AUTH_PW']) && ($_SERVER["PHP_AUTH_PW"] == 'secret'))) {
            header('HTTP/1.0 400 OK');
    }
    else {
    
        header('WWW-Authenticate: Basic realm="Test Authentication System"');
        header('HTTP/1.0 401 Unauthorized');
        echo "You must enter a valid login ID and password to access this resource\n";
    }
    exit;
}
 //$_SERVER["PHP_AUTH_USER"] = "Jimmy";
if (!isset($_SERVER['PHP_AUTH_USER']) ||
    ($_POST['SeenBefore'] == 1 && $_POST['OldAuth'] == $_SERVER['PHP_AUTH_USER'])) {
    
    authenticate();
} else {
    echo "<p>Welcome: " . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "<br />";
    
    echo "<form action='' method='post'>\n";
    echo "<input type='hidden' name='SeenBefore' value='1' />\n";
    echo "<input type='hidden' name='OldAuth' value=\"" . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "\" />\n";
    echo "<input type='submit' value='Re Authenticate' />\n";
    echo "</form></p>\n";
}
?>