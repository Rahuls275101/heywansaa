<div class="ltn__login-area pb-65 pt-60">
    <div class="container">

        <!-- Section Title -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="section-title">Forgot Password</h1>
            </div>
        </div>

        <!-- Flash Messages -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('message'); ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h2 class="text-center mb-4">Reset Password</h2>

                    <form action="<?= site_url('auth/updatePassword') ?>" method="post">
                        <input type="hidden" name="token" value="<?= $token ?>">

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input 
                                type="password" 
                                name="new_password" 
                                id="new_password" 
                                class="form-control" 
                                placeholder="Enter new password" 
                                required
                            >
                            <p id="new_password_error" class="text-danger small mt-1"></p>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input 
                                type="password" 
                                name="confirm_password" 
                                id="confirm_password" 
                                class="form-control" 
                                placeholder="Re-enter new password" 
                                required
                            >
                            <p id="confirm_password_error" class="text-danger small mt-1"></p>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
