<?php
include_once("../api/components/validatesession.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column justify-content-center align-items-center vw-100 vh-100">
    <nav class="navbar fixed-top navbar-expand-lg vw-100 shadow light-blue">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#" id="userWelcome">Hello, <?php echo $firstName . " " . $lastName; ?>!</a>
            <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-2">
                        <button class="btn btn-danger shadow" aria-current="page"
                            style="border-width: 1px; border-color: #fdfdfd78;">Logout</button>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="modal" id="exampleModal" tabindex="-1">
        <div class="modal-dialog d-flex justify-content-center align-items-center w-100 h-100">
            <div class="modal-content w-sm-75 w-md-100 vh-50">
                <div class="modal-header light-blue">
                    <h5 class="modal-title">Add Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="Add-Contact-Form" class="modal-body d-flex flex-column justify-content-center px-5 gap-2">
                    <div class="d-flex flex-column">
                        <label>First Name <span id="First-Name-Error"></span></label>
                        <input class="form-control" id="First" type="text"/>
                    </div>
                    <div class="d-flex flex-column">
                        <label>Last Name <span id="Last-Name-Error"></span></label>
                        <input class="form-control" id="Last" type="text">
                    </div>
                    <div class="d-flex flex-column">
                        <label>Email <span id="Email-Error"></span></label>
                        <input class="form-control" id="Email" type="email">
                    </div>
                    <div class="d-flex flex-column">
                        <label>Phone Number <span id="Phone-Number-Error"></span></label>
                        <input class="form-control" id="Phone-Number" type="tel">
                    </div>
                    <div class="d-flex flex-column">
                        <label>Work Number <span id="Work-Number-Error"></span></label>
                        <input class="form-control" id="Work-Number" type="tel">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" id="Submit-Contact" >Save Contact</button>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="editModal" tabindex="-1">
        <div class="modal-dialog d-flex justify-content-center align-items-center w-100 h-100">
            <div class="modal-content w-sm-75 w-md-100 vh-50">
                <div class="modal-header light-blue">
                    <h5 class="modal-title">Edit Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="Add-Contact-Form" class="modal-body d-flex flex-column justify-content-center px-5 gap-2">
                    <div class="d-flex flex-column">
                        <label>First Name <span id="First-Name-Error"></span></label>
                        <input id="input-first-name" class="form-control" id="First" type="text"/>
                    </div>
                    <div class="d-flex flex-column">
                        <label>Last Name <span id="Last-Name-Error"></span></label>
                        <input id="input-last-name" class="form-control" id="Last" type="text">
                    </div>
                    <div class="d-flex flex-column">
                        <label>Email <span id="Email-Error"></span></label>
                        <input id="input-email" class="form-control" id="Email" type="email">
                    </div>
                    <div class="d-flex flex-column">
                        <label>Phone Number <span id="Phone-Number-Error"></span></label>
                        <input id="input-personal-number" class="form-control" id="Phone-Number" type="tel">
                    </div>
                    <div class="d-flex flex-column">
                        <label>Work Number <span id="Work-Number-Error"></span></label>
                        <input id="input-work-number" class="form-control" id="Work-Number" type="tel">
                    </div>
                    <div id="contact-id" class="d-none"></div>
                    <button type="submit" class="btn btn-primary mt-3" id="update-contact" >Update Contact</button>
                </form>
            </div>
        </div>
    </div>
    <container class="d-flex rounded-4 flex-column shadow-sm w-75 h-75 justify-content-center align-items-center p-4 border">
        <Nav class="w-100 d-flex flex-row mb-2">
            <input class="form-control w-75 me-3" placeholder="Search" />
            <button class="btn btn-primary w-25 d-none d-md-block" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Contact</button>
            <button class="btn btn-primary w-25 d-block d-md-none fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
        </Nav>
        <main class="d-flex flex-row w-100 h-100 border">
            <aside class="w-sm-100 w-md-50 w-lg-25 d-flex flex-column h-100 border justify-content-between">
                <div>
                    <div class="w-100 d-flex h-auto border-bottom">
                        <!-- <div id="profileIcon" class="ratio ratio-1x1 p-4 m-2 rounded-circle overflow-hidden shadow"
                            style="height: 1vw; width: 1vw; background-color: rgb(181, 205, 224);">
                            <h2 class="text-white text-center"
                                style="display: flex; align-items: center; justify-content: center;">J</h2>
                        </div> -->
                        <div id="contact-list" class="d-flex flex-column w-100">
                            <!-- contacts populate here -->
                        </div>
                    </div>
                    <!-- <div class="w-100 d-flex h-auto border-bottom">
                        <div id="profileIcon" class="ratio ratio-1x1 p-4 m-2 rounded-circle overflow-hidden shadow"
                            style="height: 1vw; width: 1vw;background-color: rgb(181, 205, 224);">
                            <h2 class="text-white text-center"
                                style="display: flex; align-items: center; justify-content: center;">L</h2>
                        </div>
                        <div class="d-flex flex-column w-100 align-items-center justify-content-center">
                            <a href="#" class="w-100 p-2 fw-bold">Lauren Day</a>
                        </div>
                    </div> -->
                </div>
                <div class="d-flex w-100 justify-content-evenly p-3">
                    <button class="d-none btn btn-outline-primary">&lt;</button>
                    <button class="btn btn-outline-primary">1</button>
                    <button class="btn btn-outline-primary">2</button>
                    <button class="btn btn-outline-primary">3</button>
                    <button class="btn btn-outline-primary">&gt;</button>
                </div>
            </aside>
            <div class="d-none d-md-block w-75 d-flex p-5 flex-column gap-4 border position-relative">
                <a id="edit-contact" class="position-absolute top-0 end-0 m-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                <h1 id="name-header" class="d-flex flex-row fs-2 justify-content-center">
                    <div id="first-name-div" class="me-3">Jake</div>
                    <div id="last-name-div" >Dove</div>
                </h1>
                <div id="phone-number-div">Phone number: (555)-555-5555</div>
                <div id="work-number-div">Work Number: (123)-456-7890</div>
                <div id="email-div">Email: Jdove@example.com</div>
                <button>delete contact</button>
            </div>
        </main>
    </container>
    <script src="../js/contacts.js"></script>
</body>

</html>