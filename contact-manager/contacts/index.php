<?php
include_once("../api/components/validatesession.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body class="d-flex align-items-center justify-content-center vw-100 vh-100">
    <nav class="navbar navbar-expand-lg vw-100 shadow"
        style="position: fixed; top:0; background-color: rgb(44 103 237);">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#" id="userWelcome">Hello,
                <?php echo $firstName . " " . $lastName; ?>!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-2">
                        <button class="btn btn-danger shadow" aria-current="page" style="border-width: 1px; border-color: #fdfdfd78;">Logout</button>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <container class="d-flex flex-column w-75 h-75 justify-content-center align-items-center p-4 border">
        <Nav class="w-100 d-flex flex-row mb-2">
            <input class="form-control w-75 me-3" placeholder="Search" />
            <button class="btn btn-primary w-25">Add Contact</button>
        </Nav>
        <main class="d-flex flex-row w-100 h-100 border">
            <aside class="w-25 d-flex flex-column h-100 border justify-content-between">
                <div>
                    <div class="w-100 d-flex h-auto border-bottom">
                        <div id="profileIcon" class="ratio ratio-1x1 p-4 m-2 rounded-circle overflow-hidden shadow"
                            style="height: 1vw; width: 1vw; background-color: rgb(181, 205, 224);">
                            <h2 class="text-white text-center"
                                style="display: flex; align-items: center; justify-content: center;">J</h2>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <a href="#" class="w-100 p-2 bg-body-secondary fw-bold">Jake Dove</a>
                            <a href="#" class="w-100 p-2">John Doe</a>
                        </div>
                    </div>
                    <div class="w-100 d-flex h-auto border-bottom">
                        <div id="profileIcon" class="ratio ratio-1x1 p-4 m-2 rounded-circle overflow-hidden shadow"
                            style="height: 1vw; width: 1vw;background-color: rgb(181, 205, 224);">
                            <h2 class="text-white text-center"
                                style="display: flex; align-items: center; justify-content: center;">L</h2>
                        </div>
                        <div class="d-flex flex-column w-100 align-items-center justify-content-center">
                            <a href="#" class="w-100 p-2 fw-bold">Lauren Day</a>
                        </div>
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-evenly p-3">
                    <button class="btn btn-outline-primary">&lt;&lt;</button>
                    <button class="btn btn-outline-primary">&lt;</button>
                    <button class="btn btn-outline-primary">1</button>
                    <button class="btn btn-outline-primary">2</button>
                    <button class="btn btn-outline-primary">3</button>
                    <button class="btn btn-outline-primary">...</button>
                    <button class="btn btn-outline-primary">&gt;</button>
                    <button class="btn btn-outline-primary">&gt;&gt;</button>
                </div>
            </aside>
            <div class="w-75 d-flex p-5 flex-column gap-4 border">
                <h1 class="d-flex flex-row justify-content-center">
                    <div class="me-3">Jake</div>
                    <div>Dove</div>
                </h1>
                <div>Phone number: (555)-555-5555</div>
                <div>Work Number: (123)-456-7890</div>
                <div>Email: Jdove@example.com</div>
            </div>
        </main>
    </container>
</body>

</html>