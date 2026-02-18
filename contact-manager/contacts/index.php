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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column justify-content-center align-items-center vw-100 vh-100">
    <nav class="navbar fixed-top navbar-expand-lg vw-100 shadow light-blue">
        <div class="container-fluid vw-100 d-flex justify-content-between">
            <a class="navbar-brand text-white" href="#" id="userWelcome">Hello, <?php echo $firstName . " " . $lastName; ?>!</a>
            <!-- <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class=" " id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <button id="logout" class="btn btn-danger shadow" aria-current="page"
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
                    <button id="close-add-btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button id="update-close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <div class="modal" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-sm d-flex justify-content-center align-items-center w-100 h-100">
            <div class="modal-content w-sm-75 w-md-100 vh-50">
                <div class="modal-header light-blue">
                    <h5 class="modal-title text-center">Are you sure you want to delete?</h5>
                </div>
                <div class="modal-body d-flex justify-content-around">
                    <button type="button" class="btn btn-primary w-25" id="delete-button">Yes</button>
                    <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>
    <container class="d-flex rounded-4 flex-column shadow w-75 h-75 justify-content-center align-items-center p-4 border">
        <Nav class="w-100 d-flex flex-row mb-2">
            <input id="search" class="form-control w-75 me-3" placeholder="Search" />
            <button class="btn btn-primary w-25 d-none d-md-block" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Contact</button>
            <button class="btn btn-primary w-25 d-block d-md-none fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
        </Nav>
        <main class="d-flex flex-row w-100 h-100 border overflow-y-scroll">
            <aside id="aside" class="w-sm-100 w-md-50 w-lg-25 d-flex flex-column h-100 border justify-content-between">
                <div id="names-list" class="overflow-y-scroll">
                    <!-- Contacts populate here -->
                </div>
                <div id="pagination-container" class="d-flex w-100 justify-content-evenly p-3">
                    <button id="prev-btn" class="btn btn-outline-primary">&lt;</button>
                    <button id="first-btn" class="btn btn-outline-primary active"></button>
                    <button id="second-btn" class="btn btn-outline-primary"></button>
                    <button id="next-btn" class="btn btn-outline-primary">&gt;</button>
                </div>
            </aside>
            <div id="details-view" class="d-none overflow-y-scroll d-md-block w-75 d-flex flex-column border position-relative">
                <a id="go-back" class="position-absolute top-0 start-0 m-3 text-decoration-none d-none" href="#"><</a>
                <a id="edit-contact" class="position-absolute top-0 end-0 m-3 text-decoration-none" data-bs-toggle="modal" data-bs-target="#editModal" href="#"></a>
                <h1 id="name-header" class="d-flex p-5 m-0 h-25 flex-row fs-1 justify-content-center align-items-end">
                    <div id="first-name-div" class="me-3"></div>
                    <div id="last-name-div" ></div>
                </h1>
                <div id="details-container" class="d-none h-75 d-flex align-items-center flex-column">
                    <div id="communication" class="mb-4 d-flex justify-content-around w-75 fs-6">
                        <a id="msg-icon" class="bg-primary rounded-circle p-3 fa-solid fa-message text-decoration-none text-white"  href="#"></a>
                        <a id="phone-icon" class="bg-primary rounded-circle p-3 fa-solid fa-phone text-decoration-none text-white"  href="#"></a>
                        <a id="email-icon" class="bg-primary rounded-circle p-3 fa-solid fa-envelope text-decoration-none text-white"  href="#"></a>
                    </div> 
                    <div id="details-card" class="h-auto border d-flex flex-column w-75 p-3 p-md-4 p-lg-5 border-3 rounded-4">
                        <div id="details" class="h-100 d-flex flex-column gap-4 ">
                            <div class="d-flex flex-column w-100">
                                <div class="m-0 fs-6 fw-bold">Phone Number</div>
                                <div id="phone-number-div"></div>
                            </div>
                            <div id="work-number-details" class="d-flex flex-column w-100">
                                <div class="m-0 fw-bold">Work Number</div>
                                <div id="work-number-div"></div>
                            </div>
                            <div id="email-details" class="d-flex flex-column w-100">
                                <div class="m-0 fw-bold">Email</div>
                                <p id="email-div" class="text-break"></p>
                            </div>
                        </div>
                        <button class="btn btn-danger mt-sm-2 mt-md-4" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Contact</button>
                    </div>
                </div>
            </div>
        </main>
    </container>
    <script src="../js/contacts.js"></script>
</body>

</html>