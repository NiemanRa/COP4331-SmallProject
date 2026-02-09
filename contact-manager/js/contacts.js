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

    if (email.value === null || email.value === "") {
        emailError.parentElement.classList.add("text-danger");
        emailError.textContent = " is required*";
        valid = false;
    } else {
        emailError.parentElement.classList.remove("text-danger");
        emailError.textContent = "";
    }

    if (phoneNumber.value !== "") {
        console.log(phoneNumber.value)
        const phoneRegex = /^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)\d{3}[\s.-]?\d{4}$/;
        if (phoneRegex.test(phoneNumber.value) === false) {
        phoneNumberError.parentElement.classList.add("text-danger");
        phoneNumberError.textContent = "is invalid";
        valid = false;
        } else {
        phoneNumberError.parentElement.classList.remove("text-danger");
        phoneNumberError.textContent = "";
        }
    }  else {
        phoneNumberError.parentElement.classList.remove("text-danger");
        phoneNumberError.textContent = "";
    }

    if (workNumber.value !== "") {
        console.log(workNumber.value)
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
                phoneNumber: checkIfNull(phoneNumber),
                workNumber: checkIfNull(workNumber)
            })
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
    } catch (error) {
        console.error(error.message);
    }
}