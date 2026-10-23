<?php
require __DIR__ . '/includes/bootstrap.php';
no_cache();
if (!request_is_post() || !verify_csrf()) { http_response_code(405); exit('This request could not be completed. Return to the site and try again.'); }
$_SESSION = [];
if (ini_get('session.use_cookies')) { $params=session_get_cookie_params(); setcookie(session_name(), '', ['expires'=>time()-42000,'path'=>$params['path'],'domain'=>$params['domain'],'secure'=>$params['secure'],'httponly'=>$params['httponly'],'samesite'=>'Lax']); }
session_destroy(); session_start(); flash('success','You have been securely logged out.'); redirect('login.php');
