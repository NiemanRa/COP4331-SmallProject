const form = document.getElementById("Add-Contact-Form");
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

form.addEventListener("submit", (e) => {
    let valid = true;
    if (firstName.value === null || firstName.value === "") {
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

    if (phoneNumber.value === null || phoneNumber.value === "") {
        phoneNumberError.parentElement.classList.add("text-danger");
        phoneNumberError.textContent = "is required*";
        valid = false;
    }  else {
        const phoneRegex = /^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)\d{3}[\s.-]?\d{4}$/;
        if (phoneRegex.test(phoneNumber.value) === false) {
            phoneNumberError.parentElement.classList.add("text-danger");
            phoneNumberError.textContent = "is invalid";
        } else {
        phoneNumberError.parentElement.classList.remove("text-danger");
        phoneNumberError.textContent = "";
        }
    }

    if (workNumber.value !== "") {
        const phoneRegex = /^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)\d{3}[\s.-]?\d{4}$/;
        if (phoneRegex.test(workNumber.value) === false) {
        workNumberError.parentElement.classList.add("text-danger");
        workNumberError.textContent = "is invalid";
        valid = false;
        } else {
        workNumberError.parentElement.classList.remove("text-danger");
        workNumberError.textContent = "";
        }
    }  else {
        workNumberError.parentElement.classList.remove("text-danger");
        workNumberError.textContent = "";
    }

    if (valid === false) {
        e.preventDefault();
    } else {
        addContact();
    }
});

async function addContact() {
    function checkIfNull(input) {
        const value = input.value.trim();
        return value === "" ? null : value; 
    };
    try {
        const response = await fetch("/api/contacts/add.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                first_name: checkIfNull(firstName),
                last_name: checkIfNull(lastName),
                email: checkIfNull(email),
                personal_phone: checkIfNull(phoneNumber),
                work_phone: checkIfNull(workNumber)
            })
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
    } catch (error) {
        console.error(error.message);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    searchContact("", 1);
});

async function searchContact(searchQuery, pagination) {
    try {
        const response = await fetch("/api/contacts/search.php", {
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
        populateContacts(data.contacts);
    } catch (error) {
        console.error(error);
    }
}

function populateContacts(contacts) {
    document.getElementById("contact-id").value = contacts[0].id;
    document.getElementById("first-name-div").textContent = `${contacts[0].first_name}`;
    document.getElementById("last-name-div").textContent = `${contacts[0].last_name}`;
    document.getElementById("phone-number-div").textContent = `Phone number: ${contacts[0].personal_phone}`;
    document.getElementById("work-number-div").textContent = `Work Number: ${contacts[0].work_phone}`;
    document.getElementById("email-div").textContent = `${contacts[0].email}`;
    document.getElementById("edit-contact").addEventListener("click", () => {
        document.getElementById("contact-id").value = contacts[0].id;
        document.getElementById("input-first-name").value = `${contacts[0].first_name}`;
        document.getElementById("input-last-name").value = `${contacts[0].last_name}`;
        document.getElementById("input-personal-number").value = `${contacts[0].personal_phone}`;
        document.getElementById("input-work-number").value = `${contacts[0].work_phone}`;
        document.getElementById("input-email").value = `${contacts[0].email}`;
    })

    contacts.forEach((contact) => {
        const element = document.createElement("a");
        element.className = "w-100 p-2 text-decoration-none border-bottom border-start";
        element.id = `${contact.id}`
        element.addEventListener("click", () => {
            getContactDetails(contact.id, contacts);
        })
        element.textContent = `${contact.first_name}`;
        document.getElementById("contact-list").appendChild(element);
    });
}

function getContactDetails(contact_id, contacts) {
    document.getElementById("contact-id").value = contact_id;
    document.getElementById("first-name-div").textContent = `${contacts[contact_id-1].first_name}`;
    document.getElementById("last-name-div").textContent = `${contacts[contact_id-1].last_name}`;
    document.getElementById("phone-number-div").textContent = `Phone number: ${contacts[contact_id-1].personal_phone}`;
    document.getElementById("work-number-div").textContent = `Work Number: ${contacts[contact_id-1].work_phone}`;
    document.getElementById("email-div").textContent = `Email: ${contacts[contact_id-1].email}`;
    document.getElementById("edit-contact").addEventListener("click", () => {
        document.getElementById("contact-id").value = contact_id;
        document.getElementById("input-first-name").value = `${contacts[contact_id-1].first_name}`;
        document.getElementById("input-last-name").value = `${contacts[0].last_name}`;
        document.getElementById("input-personal-number").value = `${contacts[0].personal_phone}`;
        document.getElementById("input-work-number").value = `${contacts[0].work_phone}`;
        document.getElementById("input-email").value = `${contacts[0].email}`;
    })
}

document.getElementById("update-contact").addEventListener("click", () => {
    const contact = {
        contact_id: document.getElementById("contact-id").value,
        first_name: document.getElementById("input-first-name").value,
        last_name: document.getElementById("input-last-name").value,
        email: document.getElementById("input-email").value,
        personal_phone: document.getElementById("input-personal-number").value,
        work_phone: document.getElementById("input-work-number").value,
    }
    updateContact(contact);
});

async function updateContact(contact) {
    try {
        const response = await fetch("/api/contacts/update.php", {
            method:"POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "same-origin",
            body: JSON.stringify(contact)
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
    } catch (error) {
        console.error(error.message);
    }
}

async function deleteContact() {
    try {
        const response = await fetch("/api/contacts/delete.php", {
            method:"DELETE",
            headers: {},
            body: JSON.stringify({

            })
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
    } catch (error) {
        console.error(error.message);
    }
}

