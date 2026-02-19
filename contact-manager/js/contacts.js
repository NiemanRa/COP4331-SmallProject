const addform = document.getElementById("Add-Contact-Form");
const searchButton = document.getElementById("search");
const firstName = document.getElementById("First");
const lastName = document.getElementById("Last");
const email = document.getElementById("Email");
const phoneNumber = document.getElementById("Phone-Number");
const workNumber = document.getElementById("Work-Number");

const firstNameError = document.getElementById("First-Name-Error");
const lastNameError = document.getElementById("Last-Name-Error");
const emailError = document.getElementById("Email-Error");
const phoneNumberError = document.getElementById("Phone-Number-Error");
const workNumberError = document.getElementById("Work-Number-Error");

const updateFirstNameError = document.getElementById("Update-First-Name-Error");
const updateLastNameError = document.getElementById("Update-Last-Name-Error");
const updateEmailError = document.getElementById("Update-Email-Error");
const updatePhoneNumberError = document.getElementById("Update-Phone-Number-Error");
const updateWorkNumberError = document.getElementById("Update-Work-Number-Error");

const prevButton = document.getElementById("prev-btn");
const firstButton = document.getElementById("first-btn");
const secondButton = document.getElementById("second-btn");
const nextButton = document.getElementById("next-btn");

const contactId = document.getElementById("contact-id");
const firstNameDiv = document.getElementById("first-name-div");
const lastNameDiv = document.getElementById("last-name-div");
const phoneNumberDiv = document.getElementById("phone-number-div");
const workNumberDiv = document.getElementById("work-number-div");
const emailDiv = document.getElementById("email-div");
const inputFirstName = document.getElementById("input-first-name");
const inputLastName = document.getElementById("input-last-name");
const inputPersonalNumber = document.getElementById("input-personal-number");
const inputWorkNumber = document.getElementById("input-work-number");
const inputEmail = document.getElementById("input-email");

prevButton.value = "<";
nextButton.value = ">";
firstButton.value = Number(1);
firstButton.textContent = firstButton.value;
secondButton.value = Number(2);
secondButton.textContent = secondButton.value

let page = 1;
let total_count;
let query = "";

const mobileView = window.matchMedia("(max-width: 768px)");

function checkView(view) {
    if (view.matches) {
        document.getElementById("details-view").classList.add("d-none");
        document.getElementById("aside").classList.remove("d-none");
    } else {
        document.getElementById("details-view").classList.remove("d-none");
        document.getElementById("aside").classList.remove("d-none");
        document.getElementById("details-view").classList.add("w-75");
        document.getElementById("details-view").classList.remove("w-100");
        document.getElementById("details-card").classList.add("w-50");
        document.getElementById("details-card").classList.remove("w-75");
        document.getElementById("details-card").classList.add("w-50");
        document.getElementById("details-card").classList.remove("w-75");
        document.getElementById("communication").classList.add("w-50");
        document.getElementById("communication").classList.remove("w-75");
        document.getElementById("communication").classList.add("fs-4");
        document.getElementById("communication").classList.remove("fs-6");
        document.getElementById("go-back").classList.add("d-none");
    }
}

document.addEventListener("DOMContentLoaded", () => {
    searchContact(query, page);
    checkView(mobileView);
});

mobileView.addEventListener("change", (e) => {
    checkView(e);
})

document.getElementById("go-back").addEventListener("click", () => {checkView(mobileView)})

function validateForm(e, first, phone_number, work_number, email, firstNameError, phoneNumberError, workNumberError, emailError) {
    e.preventDefault();
    let valid = true;
    if (first.value === null || first.value === "") {
        firstNameError.parentElement.classList.add("text-danger");
        firstNameError.textContent = " is required*";
        valid = false;
    } else {
        firstNameError.parentElement.classList.remove("text-danger");
        firstNameError.textContent = "";
    }

    if (email.value !== "") {
        const emailRegex = /^\S+@\S+\.\S+$/;
        if (emailRegex.test(email.value) === false) {
            emailError.parentElement.classList.add("text-danger");
            emailError.textContent = " is invalid";
            valid = false;
        } else {
        emailError.parentElement.classList.remove("text-danger");
        emailError.textContent = "";
        }
    } else {
        emailError.parentElement.classList.remove("text-danger");
        emailError.textContent = "";
    }

    if (phone_number.value === null || phone_number.value === "") {
        phoneNumberError.parentElement.classList.add("text-danger");
        phoneNumberError.textContent = "is required*";
        valid = false;
    }  else {
        const phoneRegex = /^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)\d{3}[\s.-]?\d{4}$/;
        if (phoneRegex.test(phone_number.value) === false) {
            phoneNumberError.parentElement.classList.add("text-danger");
            phoneNumberError.textContent = "is invalid";
            valid = false;
        } else {
            phone_number.value = phone_number.value.replace(/\D/g, "");
            phone_number.value = phone_number.value.slice(0,3)+"-"+phone_number.value.slice(3,6)+"-"+phone_number.value.slice(6,10);
            phoneNumberError.parentElement.classList.remove("text-danger");
            phoneNumberError.textContent = "";
        }
    }

    if (work_number.value !== "") {
        const phoneRegex = /^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)\d{3}[\s.-]?\d{4}$/;
        if (phoneRegex.test(work_number.value) === false) {
        workNumberError.parentElement.classList.add("text-danger");
        workNumberError.textContent = "is invalid";
        valid = false;
        } else {
            work_number.value = work_number.value.replace(/\D/g, "");
            work_number.value = work_number.value.slice(0,3)+"-"+work_number.value.slice(3,6)+"-"+work_number.value.slice(6,10);
            workNumberError.parentElement.classList.remove("text-danger");
            workNumberError.textContent = "";
        }
    }  else {
        workNumberError.parentElement.classList.remove("text-danger");
        workNumberError.textContent = "";
    }
    
    console.log(valid)
    return valid
}

addform.addEventListener("submit", (e) => {
    validateForm(e, firstName, phoneNumber, workNumber, email, firstNameError, phoneNumberError, workNumberError, emailError).then((ok) => {
        if (ok) {
            addContact();
        } else {
            return
        }
    });
});

function checkIfNull(input) {
    const value = input.value.trim();
    return value === "" ? "" : value; 
};

async function addContact() {
    const submission = JSON.stringify({
                first_name: checkIfNull(firstName),
                last_name: checkIfNull(lastName),
                email: checkIfNull(email),
                personal_phone: checkIfNull(phoneNumber),
                work_phone: checkIfNull(workNumber)
    })
    try {
        const response = await fetch("../api/contacts/add.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "same-origin",
            body: submission
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        searchContact(query, page);
        document.getElementById("close-add-btn").click();
        clearAddContactForm();
    } catch (error) {
        console.error(error.message);
    }
}

function clearAddContactForm() {
    firstName.value = "";
    lastName.value = "";
    email.value = "";
    phoneNumber.value = "";
    workNumber.value = "";
}

async function searchContact(searchQuery, pagination) {
    try {
        const response = await fetch("../api/contacts/search.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            credentials: "same-origin",
            body: JSON.stringify({
                search_query: searchQuery,
                pagination: pagination
            })
        })
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        } 
        const data = await response.json();
        total_count = data.total_contact_count;
        const groups = {};
        for (const contact of data.contacts) {
            const letter = contact.first_name[0].toUpperCase();
            if (!groups[letter]) groups[letter] = [];
            groups[letter].push(contact);
        }
        if (Object.keys(groups).length > 0) {
            populateContacts(groups)
        } else {
            document.getElementById("pagination-container").classList.add("d-none");
        }
    } catch (error) {
        console.error(error);
    }
}

function populateContacts(groups) {
    document.getElementById("names-list").innerHTML = "";
    if (firstNameDiv.textContent === "") {
        document.getElementById("edit-contact").textContent = "Edit";
        document.getElementById("details-container").classList.remove("d-none");

        contactId.value = Object.values(groups)[0][0].id;
        firstNameDiv.textContent = `${Object.values(groups)[0][0].first_name}`;
        lastNameDiv.textContent = `${Object.values(groups)[0][0].last_name}`;
        phoneNumberDiv.textContent = `${Object.values(groups)[0][0].personal_phone}`;
        workNumberDiv.textContent = `${Object.values(groups)[0][0].work_phone}`;
        emailDiv.textContent = `${Object.values(groups)[0][0].email}`;
        contactId.value = Object.values(groups)[0][0].id;
        inputFirstName.value = `${Object.values(groups)[0][0].first_name}`;
        inputLastName.value = `${Object.values(groups)[0][0].last_name}`;
        inputPersonalNumber.value = `${Object.values(groups)[0][0].personal_phone}`;
        inputWorkNumber.value = `${Object.values(groups)[0][0].work_phone}`;
        inputEmail.value = `${Object.values(groups)[0][0].email}`;

        document.getElementById("msg-icon").href = `sms:${phoneNumberDiv.textContent}`;
        document.getElementById("phone-icon").href = `tel:${phoneNumberDiv.textContent}`;
        document.getElementById("email-icon").href = `mailto:${emailDiv.textContent}`;
        checkDetails();
    };
    Object.entries(groups).forEach(([Letter, Group]) => {
        const letterContainer = document.createElement("div");
        letterContainer.className = "w-100 d-flex h-auto border-bottom";
        document.getElementById("names-list").appendChild(letterContainer);

        const profileIcon = document.createElement("div");
        profileIcon.className = "ratio ratio-1x1 p-4 m-1 rounded-circle shadow";
        profileIcon.style = "height: 30px;  width: 30px; background-color: rgb(181, 205, 224);"
        letterContainer.appendChild(profileIcon);

        const letter = document.createElement("h2");
        letter.className = "text-white text-center";
        letter.style = "display: flex; align-items: center; justify-content: center;";
        letter.textContent = Letter;
        profileIcon.appendChild(letter);

        const contactList = document.createElement("div");
        contactList.className="d-flex flex-column w-100 border-start"
        letterContainer.appendChild(contactList);

        Group.forEach((contact) => {
            const element = document.createElement("a");
            element.className = "w-100 p-2 text-decoration-none overflow-x-scroll";
            element.id = `${contact.id}`
            element.href = "#"
            const arrayPosition = Group.indexOf(contact);
            element.addEventListener("click", () => {
                getContactDetails(contact.id, Group, arrayPosition);
                if (mobileView.matches === true) {
                    document.getElementById("aside").classList.add("d-none");
                    document.getElementById("details-view").classList.remove("d-none");
                    document.getElementById("details-view").classList.remove("w-75");
                    document.getElementById("details-view").classList.add("w-100");
                    document.getElementById("go-back").classList.remove("d-none");
                }
            })
            element.textContent = `${contact.first_name} ${contact.last_name}`;
            contactList.appendChild(element);
        })
    });
    if (total_count <= 10) {
        document.getElementById("pagination-container").classList.add("d-none")
    } else {
        document.getElementById("pagination-container").classList.remove("d-none")
        secondButton.value < Math.ceil(total_count/10) ? nextButton.classList.remove("d-none") : nextButton.classList.add("d-none")
        firstButton.value > 1 ? prevButton.classList.remove("d-none") : prevButton.classList.add("d-none")
    }
}

document.querySelectorAll(".btn-outline-primary").forEach((btn) => {

    btn.addEventListener("click", () => {
        if (btn.value === ">") {
            page+=1;
            firstButton.value = Number(firstButton.value)+1;
            secondButton.value = Number (secondButton.value)+1;
            firstButton.textContent = firstButton.value;
            secondButton.textContent = secondButton.value
        } else if (btn.value === "<") {
            page-=1;
            firstButton.value = Number(firstButton.value)-1;
            secondButton.value = Number (secondButton.value)-1;
            firstButton.textContent = firstButton.value;
            secondButton.textContent = secondButton.value
        } else if (btn.value === firstButton.value) {
            page = Number(btn.value);
            firstButton.classList.add("active");
            secondButton.classList.remove("active");
        } else if (btn.value === secondButton.value) {
            page = Number(btn.value);
            firstButton.classList.remove("active");
            secondButton.classList.add("active");
        }
        searchContact(query, page);
    });
});


function getContactDetails(contact_id, contacts, arrayPosition) {
    contactId.value = contact_id;
    firstNameDiv.textContent = `${contacts[arrayPosition].first_name}`;
    lastNameDiv.textContent = `${contacts[arrayPosition].last_name}`;
    phoneNumberDiv.textContent = `${contacts[arrayPosition].personal_phone}`;
    workNumberDiv.textContent = `${contacts[arrayPosition].work_phone}`;
    emailDiv.textContent = `${contacts[arrayPosition].email}`;
    inputFirstName.value = `${contacts[arrayPosition].first_name}`;
    inputLastName.value = `${contacts[arrayPosition].last_name}`;
    inputPersonalNumber.value = `${contacts[arrayPosition].personal_phone}`;
    inputWorkNumber.value = `${contacts[arrayPosition].work_phone}`;
    inputEmail.value = `${contacts[arrayPosition].email}`;

    document.getElementById("msg-icon").href = `sms:${phoneNumberDiv.textContent}`;
    document.getElementById("phone-icon").href = `tel:${phoneNumberDiv.textContent}`;
    document.getElementById("email-icon").href = `mailto:${emailDiv.textContent}`;
    checkDetails();
}

function checkDetails() {
    if (emailDiv.textContent === "") {
        document.getElementById("email-icon").classList.add("d-none");
        document.getElementById("email-details").classList.add("d-none");
    } else {
        document.getElementById("email-icon").classList.remove("d-none");
        document.getElementById("email-details").classList.remove("d-none");
    }

    if (workNumberDiv.textContent === "") {
        document.getElementById("work-number-details").classList.add("d-none");
    } else {
        document.getElementById("work-number-details").classList.remove("d-none");
    }
}

document.getElementById("Update-Contact-Form").addEventListener("submit", (e) => {
    if (validateForm(e, inputFirstName, inputPersonalNumber, inputWorkNumber, inputEmail, updateFirstNameError, updatePhoneNumberError, updateWorkNumberError, updateEmailError) === true) {
            document.getElementById("update-close").click();
            updateContact().then((ok) => {
                if (ok) {
                console.log("hello")
                firstNameDiv.textContent = `${inputFirstName.value}`;
                lastNameDiv.textContent = `${inputLastName.value}`;
                phoneNumberDiv.textContent = `${inputPersonalNumber.value}`;
                workNumberDiv.textContent = `${inputWorkNumber.value}`;
                emailDiv.textContent = `${inputEmail.value}`;
                checkDetails();
                searchContact(query, page);
                } else {
                    return
                }
            });
    };
});

async function updateContact() {
    const submission = {
        contact_id: contactId.value,
        first_name: checkIfNull(inputFirstName),
        last_name: checkIfNull(inputLastName),
        email: checkIfNull(inputEmail),
        personal_phone: checkIfNull(inputPersonalNumber),
        work_phone: checkIfNull(inputWorkNumber)
    }
    console.log(submission)
    try {
        const response = await fetch("../api/contacts/update.php", {
            method:"POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "same-origin",
            body: JSON.stringify(submission)
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        return true
    } catch (error) {
        console.error(error.message);
        return false
    }
}

document.getElementById("delete-button").addEventListener("click", () => {
    const contact_id = contactId.value;
    deleteContact(contact_id).then((ok) => {
        if (ok) location.reload();
    });
})

async function deleteContact(contact_id) {
    try {
        const response = await fetch("../api/contacts/delete.php", {
            method:"DELETE",
            headers: {"Content-Type": "application/json"},
            credentials: "same-origin",
            body: JSON.stringify({
                contact_id: contact_id
            })
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        return true
    } catch (error) {
        console.error(error.message);
        return false
    }
}

searchButton.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        query = searchButton.value;
        page = 1;
        firstButton.value = Number(1);
        firstButton.textContent = firstButton.value;
        secondButton.value = Number(2);
        secondButton.textContent = secondButton.value
        firstButton.classList.add("active");
        secondButton.classList.remove("active");
        searchContact(query, page)
        checkView(mobileView);
    }
})

async function doLogout() {
    try {
        const response = await fetch("../api/logout.php", {
            method: "POST"});
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        if (response.status === 200) {
            window.location.href = "../login";
        }
    } catch (error) {
        console.error(error.message);
    }
}

document.getElementById("logout").addEventListener("click", () => {
    doLogout();
})