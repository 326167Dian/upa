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
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                <option value="">Pilih role</option>
                <option value="admin" @selected(old('role', $operator->role) === 'admin')>Admin</option>
                <option value="user" @selected(old('role', $operator->role) === 'user')>User</option>
            </select>
            @error('role')
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
        class="form-control @error('full_address') is-invalid @enderror"
        placeholder="Masukkan alamat lengkap"
    >{{ old('full_address', $operator->full_address) }}</textarea>
    @error('full_address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('operators.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>