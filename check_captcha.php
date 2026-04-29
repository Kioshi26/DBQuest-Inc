<?php
echo "<h1>System Check</h1>";

// Check 1: Server Software
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Check 2: GD Library
if (extension_loaded('gd')) {
    echo "<p style='color:green'><strong>[PASS] GD Library is enabled.</strong></p>";
    $gd_info = gd_info();
    echo "<pre>";
    print_r($gd_info);
    echo "</pre>";
} else {
    echo "<p style='color:red'><strong>[FAIL] GD Library is NOT enabled.</strong> Captcha cannot be generated.</p>";
    echo "<p>To fix this in XAMPP:</p>";
    echo "<ul>";
    echo "<li>Open <code>xampp/php/php.ini</code></li>";
    echo "<li>Find <code>;extension=gd</code></li>";
    echo "<li>Remove the semicolon (;) to make it <code>extension=gd</code></li>";
    echo "<li>Restart Apache in XAMPP Control Panel.</li>";
    echo "</ul>";
}

// Check 3: Session
if (session_start()) {
    $_SESSION['test'] = 'working';
    echo "<p style='color:green'><strong>[PASS] Session started successfully.</strong></p>";
} else {
    echo "<p style='color:red'><strong>[FAIL] Session could not start.</strong></p>";
}

// Check 4: Output Buffering (if unintentional output is breaking images)
echo "<p><strong>Output Buffering Level:</strong> " . ob_get_level() . "</p>";

?>