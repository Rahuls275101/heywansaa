<main class="main log-new-main py-5">
    <div class="container">
        
        <!-- Page Title -->
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

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h2 class="text-center mb-4">Forgot Password</h2>
                    <form action="<?= site_url('auth/sendResetLink') ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="Enter your email" 
                                required
                            >
                            <p id="email_error" class="text-danger small mt-1"></p>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Send Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>
