<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Task Manager</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            Task Manager
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if ($auth) : ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/user/logout">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else : ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                            Login
                        </button>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div id="alertMessage" class="p-5">
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?=$_SESSION['error']; unset($_SESSION['error'])?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?=$_SESSION['success']; unset($_SESSION['success'])?>
        </div>
    <?php endif; ?>
</div>
<div class="p-5">
    <?= $content ?>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/user/login" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Sign in</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin-email" class="col-form-label">Login</label>
                        <input type="text" name="login" class="form-control" id="admin-email">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required
                               autocomplete="current-password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        setTimeout(function(){
            document.getElementById("alertMessage").innerHTML = "";
        }, 5000);
    })();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
</body>
</html>
