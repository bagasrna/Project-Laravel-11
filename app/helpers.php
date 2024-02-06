<?php

use Spatie\Permission\Models\Permission;

if (!function_exists('formatBytes')) {
    function formatBytes(int $bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1000, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('formatBits')) {
    function formatBits(int $bytes, $precision = 2)
    {
        $bits = $bytes * 8;
        $units = array('b', 'Kb', 'Mb', 'Gb');

        $bits = max($bits, 0);
        $pow = floor(($bits ? log($bits) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bits /= pow(1000, $pow);

        return round($bits, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('byteToGigabyte')) {
    function byteToGigabyte(int $bytes)
    {
        $bytes = max($bytes, 0);
        $bytes /= pow(1000, 3);
        return round($bytes, 3);
    }
}

if (!function_exists('byteToAnother')) {
    function byteToAnother(int $bytes, int $pow)
    {
        $bytes = max($bytes, 0);
        $bytes /= pow(1000, $pow);
        return round($bytes, 3);
    }
}

if (!function_exists('createAndGiveResourcePermission')) {
    function createAndGiveResourcePermission($role, $actions, $rolePermission, $guard)
    {
        collect($rolePermission)->each(function ($permission) use ($role, $actions, $guard) {
            collect($actions)->each(function ($action) use ($role, $permission, $guard) {
                $permission = Permission::query()->firstOrCreate([
                    'name' => "{$action} ${permission}",
                    'guard_name' => $guard
                ]);
                $permission->assignRole($role);
            });
        });
    }
}

if (!function_exists('createAndGivePermission')) {
    function createAndGivePermission($role, $permissions, $guard)
    {
        collect($permissions)->each(function ($permission) use ($role, $guard) {
            $permission = Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
            $permission->assignRole($role);
        });
    }
}

if (!function_exists('buildAuthCookie')) {
    function buildAuthCookie(string $key, ?string $value, $ttl, string $customDomain = null)
    {
        return cookie($key, $value, $ttl, null, $customDomain, true);
    }
}


if (!function_exists('formatNumber')) {
    function formatNumber(int|float $number, bool $isCurrency = false)
    {
        $number = number_format($number, 2, ',', '.');
        if ($number < 0) {
            return str_replace('-', ($isCurrency ? '- Rp' : '-'), $number);
        }
        return ($isCurrency ? 'Rp' : '') . $number;
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString(int $length = 16)
    {
        return substr(
            str_replace(
                ['+', '/', '-', '='],
                '',
                base64_encode(random_bytes($length * 2))
            ),
            0,
            $length
        );
    }
}

if (!function_exists('breakDownPhoneNumber')) {
    function breakDownPhoneNumber(string $phoneNumber): array
    {
        $phoneComponent = [];
        if ($phoneNumber[0] == '0') {
            $phoneComponent[0] = substr($phoneNumber, 0, 1);
            $phoneComponent[1] = substr($phoneNumber, 1);
        } elseif ($phoneNumber[0] == '6' && $phoneNumber[1] == '2') {
            $phoneComponent[0] = substr($phoneNumber, 0, 2);
            $phoneComponent[1] = substr($phoneNumber, 2);
        } else {
            $phoneComponent[0] = substr($phoneNumber, 0, 0);
            $phoneComponent[1] = substr($phoneNumber, 0);
        }

        return $phoneComponent;
    }
}

if (!function_exists('checkMissingNumberInSequence')) {
    function checkMissingNumberInSequence(int $start, array $seriesOfID): int
    {
        $nextId = $start - 1;
        if (!empty($seriesOfID)) {
            $last = $seriesOfID[count($seriesOfID) - 1];
            for ($i = $start; $i <= $last; $i++) {
                if ($i == $last) {
                    $nextId = $i + 1;
                    break;
                } elseif (!in_array($i, $seriesOfID)) {
                    $nextId = $i;
                    break;
                }
            }
        } else {
            $nextId += 1;
        }

        return $nextId;
    }
}

if (!function_exists('getModelClassName')) {
    function getModelClassName(?string $classNameWithNamespace, ?string $id): string|null
    {
        if ($classNameWithNamespace) {
            $explode = explode("\\", $classNameWithNamespace);
            return array_pop($explode) . " - ID:$id";
        }
        return null;
    }
}

if (!function_exists('base64UrlEncode')) {
    function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/=', '._-');
    }
}

if (!function_exists('base64UrlDecode')) {
    function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '._-', '+/='));
    }
}
