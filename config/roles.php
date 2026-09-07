<?php

// config/roles.php
//
// Single source of truth for "what role does this email get?" — read by
// App\Support\ResolveUserRoleFromEmail. Keeping this as config (not
// hard-coded in the resolver) means Ops can update the admin/accountant
// list without a code deploy — just an env change + `config:cache`.

return [

    'admins' => array_filter(explode(',', env('ROLE_ADMIN_EMAILS', ''))),
    // e.g. ROLE_ADMIN_EMAILS="sami.nabulsi@whitfieldcole.com,partner@whitfieldcole.com"

    'accountants' => array_filter(explode(',', env('ROLE_ACCOUNTANT_EMAILS', ''))),
    // e.g. ROLE_ACCOUNTANT_EMAILS="billing@whitfieldcole.com"

    'staff_domain' => env('ROLE_STAFF_DOMAIN', 'whitfieldcole.com'),

    'default_role' => 'client',

];
