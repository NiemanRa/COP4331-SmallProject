const form = document.getElementById("Add-Contact-Form");
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

const prevButton = document.getElementById("prev-btn");
const firstButton = document.getElementById("first-btn");
const secondButton = document.getElementById("second-btn");
const nextButton = document.getElementById("next-btn");

prevButton.value = "<";
nextButton.value = ">";
firstButton.value = Number(1);
firstButton.textContent = firstButton.value;
secondButton.value = Number(2);
secondButton.textContent = secondButton.value

let page = 1;
let total_count;
let query = "";

document.addEventListener("DOMContentLoaded", () => {
    searchContact(query, page);
});

form.addEventListener("submit", (e) => {
    e.preventDefault();
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
            valid = false;
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
        return
    } else {
        addContact()
    }
});

async function addContact() {
    function checkIfNull(input) {
        const value = input.value.trim();
        return value === "" ? "" : value; 
    };
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
        const sorted = data.contacts.sort(function(a,b) {
            let textA = a.first_name.toLowerCase();
            let textB = b.first_name.toLowerCase();
            return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
        })
        const groups = {};
        for (const contact of sorted) {
            const letter = contact.first_name[0].toUpperCase();
            if (!groups[letter]) groups[letter] = [];
            groups[letter].push(contact);
        }
        populateContacts(groups);
    } catch (error) {
        console.error(error);
    }
}

function populateContacts(groups) {
    document.getElementById("names-list").innerHTML = "";
    document.getElementById("contact-id").value = Object.values(groups)[0][0].id;
    document.getElementById("first-name-div").textContent = `${Object.values(groups)[0][0].first_name}`;
    document.getElementById("last-name-div").textContent = `${Object.values(groups)[0][0].last_name}`;
    document.getElementById("phone-number-div").textContent = `Phone number: ${Object.values(groups)[0][0].personal_phone}`;
    document.getElementById("work-number-div").textContent = `Work Number: ${Object.values(groups)[0][0].work_phone}`;
    document.getElementById("email-div").textContent = `${Object.values(groups)[0][0].email}`;
    document.getElementById("edit-contact").addEventListener("click", () => {
        document.getElementById("contact-id").value = Object.values(groups)[0][0].id;
        document.getElementById("input-first-name").value = `${Object.values(groups)[0][0].first_name}`;
        document.getElementById("input-last-name").value = `${Object.values(groups)[0][0].last_name}`;
        document.getElementById("input-personal-number").value = `${Object.values(groups)[0][0].personal_phone}`;
        document.getElementById("input-work-number").value = `${Object.values(groups)[0][0].work_phone}`;
        document.getElementById("input-email").value = `${Object.values(groups)[0][0].email}`;
    })
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
            element.className = "w-100 p-2 text-decoration-none ";
            element.id = `${contact.id}`
            element.href = "#"
            const arrayPosition = Group.indexOf(contact);
            element.addEventListener("click", () => {
                getContactDetails(contact.id, Group, arrayPosition);
            })
            element.textContent = `${contact.first_name}`;
            contactList.appendChild(element);
        })
    });
    console.log((total_count))
    if (total_count <= 10) {
        document.getElementById("pagination-container").classList.add("d-none")
    } else {
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
    document.getElementById("contact-id").value = contact_id;
    document.getElementById("first-name-div").textContent = `${contacts[arrayPosition].first_name}`;
    document.getElementById("last-name-div").textContent = `${contacts[arrayPosition].last_name}`;
    document.getElementById("phone-number-div").textContent = `Phone number: ${contacts[arrayPosition].personal_phone}`;
    document.getElementById("work-number-div").textContent = `Work Number: ${contacts[arrayPosition].work_phone}`;
    document.getElementById("email-div").textContent = `Email: ${contacts[arrayPosition].email}`;
    document.getElementById("edit-contact").addEventListener("click", () => {
        document.getElementById("contact-id").value = contact_id;
        document.getElementById("input-first-name").value = `${contacts[arrayPosition].first_name}`;
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
        const response = await fetch("../api/contacts/update.php", {
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

document.getElementById("delete-button").addEventListener("click", () => {
    const contact_id = document.getElementById("contact-id").value;
    deleteContact(contact_id);
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
        searchContact(query, page);
    } catch (error) {
        console.error(error.message);
    }
}

searchButton.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        query = searchButton.value;
        searchContact(query, page)
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

