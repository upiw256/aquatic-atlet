<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h4 class="mb-4">Pengaturan Email SMTP</h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('admin/email-settings/save') ?>" class="needs-validation" novalidate>
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">From Email</label>
            <input type="email" class="form-control" name="from_email"
                value="<?= esc($settings['from_email'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">From Name</label>
            <input type="text" class="form-control" name="from_name"
                value="<?= esc($settings['from_name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SMTP Host</label>
            <input type="text" class="form-control" name="smtp_host"
                value="<?= esc($settings['smtp_host'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SMTP User</label>
            <input type="email" class="form-control" name="smtp_user"
                value="<?= esc($settings['smtp_user'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SMTP Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="smtp_pass" name="smtp_pass"
                    value="<?= esc($settings['smtp_pass'] ?? '') ?>" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePass">
                    <i class="ti ti-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">SMTP Port</label>
            <input type="number" class="form-control" name="smtp_port"
                value="<?= esc($settings['smtp_port'] ?? '587') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SMTP Crypto</label>
            <select name="smtp_crypto" class="form-select">
                <option value="tls" <?= (isset($settings['smtp_crypto']) && $settings['smtp_crypto'] === 'tls') ? 'selected' : '' ?>>TLS</option>
                <option value="ssl" <?= (isset($settings['smtp_crypto']) && $settings['smtp_crypto'] === 'ssl') ? 'selected' : '' ?>>SSL</option>
                <option value="" <?= (isset($settings['smtp_crypto']) && $settings['smtp_crypto'] === '') ? 'selected' : '' ?>>Tanpa Enkripsi</option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("togglePass");
    const passwordInput = document.getElementById("smtp_pass");
    const icon = toggleBtn.querySelector("i");

    toggleBtn.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";
        icon.classList.toggle("ti-eye", !isPassword);
        icon.classList.toggle("ti-eye-off", isPassword);
    });
});
</script>
<?= $this->endSection() ?>