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

    .link:hover {
        color: blue !important;

    }
</style>
<script src="https://www.google.com/recaptcha/api.js?render=6LdIiu8qAAAAAD_3pCc6NrPekp0eES7ix02hrGiZ"></script>
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content rounded-0 ">

            <div class="container modal-body">
                <!-- Outer Row -->
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-6 d-none d-lg-block"><img src="./img/chairss.jpg" width="100%"
                                            height="100%"></div>
                                    <div class="col-lg-6">
                                        <div class="p-5">
                                            <button type="button" class="btn-close position-absolute"
                                                style="top: 10px; right: 10px;" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="text-center mb-5">
                                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>

                                            </div>


                                            <?php if (isset($_GET['error'])) { ?>
                                                <p class="errors alert alert-danger"><?php echo $_GET['error']; ?></p>
                                            <?php } ?>
                                            <form action="login.php" method="POST" class="user">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-user"
                                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                                        placeholder="Enter Email Address..." name='email'>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password"
                                                        class="form-control form-control-user mt-2 mb-4"
                                                        id="floatingPassword" name='password' placeholder="Password">
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck">
                                                        <label class="custom-control-label mb-4"
                                                            for="customCheck">Remember
                                                            Me</label>
                                                    </div>
                                                </div>
                                        </div>
                                        <center><button type="submit" name="submit"
                                                class="btn btns btn-user px-5 rounded">
                                                Login
                                            </button></center>
                                        <hr>
                                        </form>
                                        <div class="text-center">
                                            <a class="small link text-dark" href="forgot-password.php">Forgot
                                                Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small link text-dark" href="" data-bs-toggle="modal"
                                                data-bs-target="#signupModal">Create an Account!</a>
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
</div>
</div>
<!-- Modal login End -->