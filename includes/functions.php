<?php
if (session_status()===PHP_SESSION_NONE) session_start();
function cfg(string $k){ static $c; $c ??= require __DIR__.'/../config/config.php'; return $c[$k] ?? null; }
function base(): string { return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); }
function asset(string $p): string { return base().'/assets/'.$p; }
function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { return $_SESSION['t'] ??= bin2hex(random_bytes(16)); }
function section(string $n): void { include __DIR__."/../sections/$n.php"; }
