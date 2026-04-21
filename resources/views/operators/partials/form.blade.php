<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $operator->name) }}"
                placeholder="Masukkan nama operator"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                id="username"
                name="username"
                type="text"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username', $operator->username) }}"
                placeholder="Masukkan username login"
            >
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" data-role-selector="true" data-permission-scope="#feature-permissions-scope">
                <option value="">Pilih role</option>
                <option value="admin" @selected(old('role', $operator->role) === 'admin')>Admin</option>
                <option value="user" @selected(old('role', $operator->role) === 'user')>User</option>
                <option value="custom" @selected(old('role', $operator->role) === 'custom')>Akses Terbatas</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ $operator->exists ? 'Kosongkan jika tidak diubah' : 'Masukkan password login' }}"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="phone_number" class="form-label">No Telp</label>
    <input
        id="phone_number"
        name="phone_number"
        type="text"
        class="form-control @error('phone_number') is-invalid @enderror"
        value="{{ old('phone_number', $operator->phone_number) }}"
        placeholder="Masukkan nomor telepon"
    >
    @error('phone_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="full_address" class="form-label">Alamat Lengkap</label>
    <textarea
        id="full_address"
        name="full_address"
        rows="4"
        data-rich-text="ckeditor"
        class="form-control @error('full_address') is-invalid @enderror"
        placeholder="Masukkan alamat lengkap"
    >{{ old('full_address', $operator->full_address) }}</textarea>
    @error('full_address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div id="feature-permissions-scope" class="mb-4" @if (old('role', $operator->role) !== 'custom') style="display: none;" @endif>
    <label class="form-label d-block">Hak Akses Fitur</label>
    <div class="table-responsive border rounded">
        <table class="table table-sm mb-0 align-middle">
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th class="text-center">Lihat</th>
                    <th class="text-center">Tambah</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($featureDefinitions as $moduleKey => $featureDefinition)
                    <tr>
                        <td>{{ $featureDefinition['label'] }}</td>
                        @foreach (['view', 'create', 'edit', 'delete'] as $actionKey)
                            <td class="text-center">
                                @if (array_key_exists($actionKey, $featureDefinition['actions']))
                                    @php($permissionKey = \App\Support\FeaturePermission::permissionKey($moduleKey, $actionKey))
                                    <div class="form-check d-inline-flex justify-content-center mb-0">
                                        <input
                                            id="permission_{{ $moduleKey }}_{{ $actionKey }}"
                                            name="permissions[]"
                                            type="checkbox"
                                            value="{{ $permissionKey }}"
                                            class="form-check-input"
                                            @checked(in_array($permissionKey, old('permissions', $operator->permissions ?? []), true))
                                        >
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @error('permissions')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @error('permissions.*')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('operators.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>