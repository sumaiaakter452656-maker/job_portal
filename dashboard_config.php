<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const DB_HOST = 'localhost';
const DB_NAME = 'jobs_portal';
const DB_USER = 'root';
const DB_PASS = '';

/* ---------------- Database ---------------- */
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    }
    return $pdo;
}

function rows(string $sql, array $params = []): array
{
    try {
        $st = db()->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    } catch (PDOException $e) {
        error_log('[dashboard] ' . $e->getMessage());
        return [];
    }
}

function row(string $sql, array $params = []): ?array
{
    $r = rows($sql, $params);
    return $r[0] ?? null;
}

function scalar(string $sql, array $params = [], $default = 0)
{
    $r = row($sql, $params);
    if ($r === null) return $default;
    $v = reset($r);
    return $v === null ? $default : $v;
}

const LOGIN_PAGE = './login.php';  

function require_role(string $role): int
{
    $id = $_SESSION['user_id'] ?? $_SESSION['id'] ?? $_SESSION['userid']
        ?? ($_SESSION['user']['id'] ?? null);
    $userRole = $_SESSION['role'] ?? $_SESSION['user_role'] ?? $_SESSION['user_type']
        ?? ($_SESSION['user']['role'] ?? null);


    if ($id && !$userRole) {
        $userRole = scalar("SELECT role FROM users WHERE id = ?", [(int) $id], null);
    }

    if (!$id || strtolower((string) $userRole) !== $role) {
        if (!headers_sent()) {
            header('Location: ' . LOGIN_PAGE . ($id ? '?need=' . urlencode($role) : ''));
        }
        exit('<p style="font-family:sans-serif;padding:2rem">Access denied — please <a href="' . LOGIN_PAGE . '">login</a> as <b>' . $role . '</b>.</p>');
    }
    return (int) $id;
}

function e($v): string
{
    return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES, 'UTF-8');
}

function taka($n): string
{
    return '৳' . number_format((float) $n, 0);
}

function label(?string $s): string
{
    return ucwords(str_replace('_', ' ', (string) $s));
}

function initials(?string $name): string
{
    $parts = preg_split('/\s+/', trim((string) $name));
    $out = '';
    $mb = function_exists('mb_substr');
    foreach (array_slice($parts, 0, 2) as $p) {
        $ch = $mb ? mb_substr($p, 0, 1) : substr($p, 0, 1);
        $out .= $mb ? mb_strtoupper($ch) : strtoupper($ch);
    }
    return $out ?: '?';
}

function avatar_color(?string $name): string
{
    $colors = ['blue', 'green', 'orange', 'purple', 'pink', 'cyan'];
    return $colors[crc32((string) $name) % count($colors)];
}
function badge(?string $status): string
{
    $map = [
        'approved' => 'success', 'active' => 'success', 'completed' => 'success', 'hired' => 'success',
        'pending' => 'warning', 'applied' => 'warning',
        'rejected' => 'danger', 'blocked' => 'danger', 'failed' => 'danger',
        'closed' => 'secondary', 'expired' => 'secondary', 'inactive' => 'secondary',
        'viewed' => 'info', 'shortlisted' => 'primary', 'interview' => 'purple',
        'admin' => 'purple', 'employer' => 'info', 'seeker' => 'primary',
    ];
    $cls = $map[$status] ?? 'secondary';
    return '<span class="badge-soft badge-soft-' . $cls . '">' . e(label($status)) . '</span>';
}

function time_ago(?string $ts): string
{
    if (!$ts) return '';
    $diff = time() - strtotime($ts);
    if ($diff < 60)      return 'just now';
    if ($diff < 3600)    return floor($diff / 60) . ' min ago';
    if ($diff < 86400)   return floor($diff / 3600) . ' hr ago';
    if ($diff < 604800)  return floor($diff / 86400) . ' days ago';
    return date('d M Y', strtotime($ts));
}

function nice_date(?string $d): string
{
    return $d ? date('d M Y', strtotime($d)) : '—';
}

function salary_range($min, $max): string
{
    if (!$min && !$max) return 'Negotiable';
    if ($min && $max)   return taka($min) . ' – ' . taka($max);
    return taka($min ?: $max);
}


function last_months(int $n = 6): array
{
    $out = [];
    for ($i = $n - 1; $i >= 0; $i--) {
        $t = strtotime(date('Y-m-01') . " -$i month");
        $out[date('Y-m', $t)] = date('M', $t);
    }
    return $out;
}


function fill_months(array $months, array $data, string $key = 'ym', string $val = 'c'): array
{
    $map = array_column($data, $val, $key);
    $out = [];
    foreach (array_keys($months) as $ym) {
        $out[] = (int) ($map[$ym] ?? 0);
    }
    return $out;
}

function logo_or_avatar(?string $logo, ?string $name, string $size = ''): string
{
    if ($logo) {
        return '<img src="' . e($logo) . '" alt="" class="avatar ' . $size . ' avatar-img">';
    }
    return '<span class="avatar ' . $size . ' avatar-' . avatar_color($name) . '">' . e(initials($name)) . '</span>';
}
