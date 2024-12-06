<?= $this->extend('layout/auth-layout'); ?>
<?= $this->section('content'); ?>
<div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="assets/vendors/images/login-page-img.png" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To LibraryDesk</h2>
                        </div>
                        <form action="/auth/login" method="post">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="Username" name="username" value="<?= old('username') ?>" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********" name="password" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
<?= $this->endSection() ?>