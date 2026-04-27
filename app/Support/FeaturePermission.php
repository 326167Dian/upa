<?php

namespace App\Support;

class FeaturePermission
{
    /**
     * @return array<string, array{label: string, route: string, actions: array<string, string>}>
     */
    public static function definitions(): array
    {
        return [
            'dashboard' => [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'actions' => [
                    'view' => 'Lihat',
                ],
            ],
            'operators' => [
                'label' => 'Operator',
                'route' => 'operators.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
            'kegiatan' => [
                'label' => 'Kegiatan',
                'route' => 'kegiatan.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
            'kehadiran' => [
                'label' => 'Kehadiran',
                'route' => 'kehadiran.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
            'jurnal_kas' => [
                'label' => 'Jurnal Kas',
                'route' => 'jurnal-kas.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
            'pengumuman' => [
                'label' => 'Pengumuman',
                'route' => 'pengumuman.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
            'foto_kegiatan' => [
                'label' => 'Foto Kegiatan',
                'route' => 'foto-kegiatan.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
            'catatan' => [
                'label' => 'Catatan Harian',
                'route' => 'catatan.index',
                'actions' => [
                    'view' => 'Lihat',
                    'create' => 'Tambah',
                    'edit' => 'Edit',
                    'delete' => 'Hapus',
                ],
            ],
        ];
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        $keys = [];

        foreach (self::definitions() as $module => $definition) {
            foreach (array_keys($definition['actions']) as $action) {
                $keys[] = self::permissionKey($module, $action);
            }
        }

        return $keys;
    }

    /**
     * @return list<string>
     */
    public static function defaultUserPermissions(): array
    {
        $permissions = [];

        foreach (self::definitions() as $module => $definition) {
            if ($module === 'operators') {
                continue;
            }

            foreach (array_keys($definition['actions']) as $action) {
                if ($module === 'jurnal_kas' && $action !== 'view') {
                    continue;
                }

                $permissions[] = self::permissionKey($module, $action);
            }
        }

        return $permissions;
    }

    public static function permissionKey(string $module, string $action): string
    {
        return $module.'.'.$action;
    }

    /**
     * @return array<string, string>
     */
    public static function actionLabels(string $module): array
    {
        return self::definitions()[$module]['actions'] ?? [];
    }

    /**
     * @param  array<int, string>|null  $permissions
     */
    public static function grants(?array $permissions, string $permission): bool
    {
        $permissions = $permissions ?? [];

        if (in_array($permission, $permissions, true)) {
            return true;
        }

        [$module] = explode('.', $permission, 2);

        return in_array($module, $permissions, true);
    }

    /**
     * @param  array<int, string>|null  $permissions
     * @return array<int, array{module: string, actions: array<int, string>}>
     */
    public static function summarize(?array $permissions): array
    {
        $permissions = $permissions ?? [];
        $summary = [];

        foreach (self::definitions() as $module => $definition) {
            $grantedActions = [];

            if (in_array($module, $permissions, true)) {
                $summary[] = [
                    'module' => $definition['label'],
                    'actions' => array_values($definition['actions']),
                ];

                continue;
            }

            foreach ($definition['actions'] as $action => $label) {
                if (in_array(self::permissionKey($module, $action), $permissions, true)) {
                    $grantedActions[] = $label;
                }
            }

            if ($grantedActions !== []) {
                $summary[] = [
                    'module' => $definition['label'],
                    'actions' => $grantedActions,
                ];
            }
        }

        return $summary;
    }
}