<!-- Modal Login Start -->
<style type="text/css">
    .navbar-expand-lg {
        margin-bottom: 70px;
    }

    .errors {
        background: #F2DEDE;
        color: #A94442;
        padding: 10px;
        border-radius: 5px;
    }

    .btns {
        background-color: #e47011;
        color: white;
        font-weight: 700;
        margin: 2px;
    }

    .btns:hover {
        opacity: 0.8;
        border: 1px solid;
        background-color: white;
        color: black;

    }
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog reg">
        <div class="modal-content rounded  registercon">
            <div class="container  modal-body">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block"><img src="./img/chairss.jpg" width="100%"
                                    height="100%"></div>

                            <div class="col-lg-7">
                                <div class="p-5">
                                    <button type="button" class="btn-close position-absolute"
                                        style="top: 10px; right: 10px;" data-bs-dismiss="modal"
                                        aria-label="Close"></button>

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>

                                    <?php if (isset($_GET['error'])) { ?>
                                        <p class="errors alert alert-danger"><?php echo $_GET['error']; ?></p>
                                    <?php } ?>

                                    <form class="user" action="register.php" method="POST">
                                        <div class="form-group row">
                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control form-control-user"
                                                    id="exampleFirstName" name="fullName" placeholder="Full Name">
                                            </div>

                                            <div class="form-group mb-2">
                                                <input type="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" name="email" placeholder="Email Address">
                                            </div>

                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control form-control-user"
                                                    id="exampleAddress" name="address" placeholder="Address">
                                            </div>

                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control form-control-user" name="phone"
                                                    placeholder="Phone Number" maxlength="11" pattern="\d{11}"
                                                    title="Phone number must be exactly 11 digits" required
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" name="password" placeholder="Password">
                                            </div>

                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleRepeatPassword" name="confirmPassword"
                                                    placeholder="Repeat Password">
                                            </div>
                                            <br><br>

                                            <center>
                                                <div class="g-recaptcha"
                                                    data-sitekey="6LdZj-8qAAAAALBPKlHYlVdNC1M4p8cLScO7V6GJ "></div>
                                            </center>
                                        </div>
                                        <center class="mt-4">
                                            <button type="submit" class="btn btns btn-user btn-block" value="register"
                                                name="submit">
                                                Register Account
                                            </button>

                                            <button type="reset" class="btn btns btn-user btn-block">
                                                Clear
                                            </button>
                                        </center>

                                    </form>
                                    <hr>

                                    <div class="text-center">
                                        <a class="small" data-bs-toggle="modal" data-bs-target="#loginModal">Already
                                            have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal login End -->