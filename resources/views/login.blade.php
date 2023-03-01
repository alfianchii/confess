<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confess</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500&display=swap" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="../css/style.css" /> --}}
    @vite('resources/css/app.css')
</head>

<body>
    <div class="row d-block d-sm-flex height">
        <div class="col-12 col-sm-5 bg">
            <div class="0 ms-5 pt-3 mb-2 mb-sm-5 logo-login">
                <img src="../images/logoT.png" alt="illustrasi" width="20%" />
            </div>
            <div class="text-center illus-login">
                <img src="../images/illust.png" alt="logo" width="60%" />
            </div>
        </div>
        <div class="col-12 col-sm-7">
            <h1 class="w-100 fw-bold text-center mt-4 mt-sm-5 p-0 pt-sm-5 fs-3">MASUK</h1>
            <div class="card mt-5 p-sm-4 p-2 border-start-0 border-end-0 margin-form">
                <div class="card-body">
                    <form action="" method="post" class="my-4">
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control p-2" id="username" />
                        </div>
                        <div class="mb-5">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control p-2" id="password" />
                            <div class="text-end mt-4">
                                <a href="# " class="form-text">lupa password?</a>
                            </div>
                        </div>
                        <div class="text-start mt-5">
                            <button type="submit" class="w-100 btn-color btn text-white btn-primary p-2">masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
