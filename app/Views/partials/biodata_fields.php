<div class="mb-3">
    <label for="nik" class="form-label">NIK</label>
    <input type="text" class="form-control" id="nik" name="nik"
        value="<?= old('nik', $biodata['nik'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label for="fullname" class="form-label">Nama Lengkap</label>
    <input type="text" class="form-control" id="fullname" name="fullname"
        value="<?= old('fullname', $user['name'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label for="birth_place" class="form-label">Tempat Lahir</label>
    <input type="text" class="form-control" id="birth_place" name="birth_place"
        value="<?= old('birth_place', $biodata['birth_place'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label for="birth_date" class="form-label">Tanggal Lahir</label>
    <input type="date" class="form-control" id="birth_date" name="birth_date"
        value="<?= old('birth_date', $biodata['birth_date'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label for="gender" class="form-label">Jenis Kelamin</label>
    <select name="gender" class="form-select" id="gender" required>
        <option value="">-- Pilih --</option>
        <option value="laki-laki" <?= (old('gender', $biodata['gender'] ?? '') == 'laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
        <option value="perempuan" <?= (old('gender', $biodata['gender'] ?? '') == 'perempuan') ? 'selected' : '' ?>>Perempuan</option>
    </select>
</div>

<div class="mb-3">
    <label for="religion" class="form-label">Agama</label>
    <input type="text" class="form-control" id="religion" name="religion"
        value="<?= old('religion', $biodata['religion'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label for="marital_status" class="form-label">Status Pernikahan</label>
    <select name="marital_status" class="form-select" id="marital_status" required>
        <option value="">-- Pilih --</option>
        <option value="menikah" <?= (old('marital_status', $biodata['marital_status'] ?? '') == 'menikah') ? 'selected' : '' ?>>Menikah</option>
        <option value="belum" <?= (old('marital_status', $biodata['marital_status'] ?? '') == 'belum') ? 'selected' : '' ?>>Belum Menikah</option>
    </select>
</div>

<div class="mb-3">
    <label for="education" class="form-label">Pendidikan Terakhir</label>
    <input type="text" class="form-control" id="education" name="education"
        value="<?= old('education', $biodata['education'] ?? '') ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="occupation" class="form-label">Pekerjaan</label>
        <input type="text" class="form-control" id="occupation" name="occupation"
        value="<?= old('occupation', $biodata['occupation'] ?? '') ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea class="form-control" id="address" name="address" required><?= old('address', $biodata['address'] ?? '') ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="phone" class="form-label">No. HP</label>
        <input type="text" class="form-control" id="phone" name="phone"
        value="<?= old('phone', $biodata['phone'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label for="photo" class="form-label">Foto Profil</label>
    <img id="photo-preview" src="/<?= esc($biodata['photo'] ?? 'uploads/photos/default.png') ?>" alt="Foto Profil" style="width:150px; height:150px; object-fit:cover; display:block; margin-bottom:10px;">
    <input type="file" class="form-control" id="photo" name="photo" onchange="previewPhoto(event)" accept="image/*" <?= empty($biodata['photo']) ? 'required' : '' ?>>
    <input type="hidden" name="old_photo" value="<?= esc($biodata['photo'] ?? '') ?>">
</div>