<?php

return [

    // ── Subscription expiry warning banner ──
    'subscription_expiry_warning' => 'Warning: The school subscription expires in :days days. Please contact administration to avoid an interruption of the educational service.',

    // ── 403 page: Unauthorized access / expired subscription ──
    '403_heading'     => 'Unauthorized Access or Expired Subscription',
    '403_description' => 'Sorry, you do not have sufficient permissions to access this page, or the school subscription has currently expired.',
    '403_action'      => 'Return to the Unified Login Page',

    // ── 419 page: Session expired / CSRF token mismatch ──
    '419_heading'     => 'Your Secure Session Has Expired',
    '419_description' => 'The page was left open for too long without interaction. Please refresh the page and try again to protect your data.',
    '419_action'      => 'Refresh and Log In',

    // ── 404 page: Page not found ──
    '404_heading'     => 'Page Not Found',
    '404_description' => 'Sorry, the link you are trying to access does not exist or has been moved by the system administration.',
    '404_action'      => 'Return to Dashboard',

    // ── Shared elements across error pages ──
    'error_code_label' => 'Error',

];
