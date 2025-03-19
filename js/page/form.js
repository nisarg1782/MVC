document.addEventListener("DOMContentLoaded", function () {
    let forms = document.getElementsByTagName("form");
    Array.from(forms).forEach((form) => {
        form.addEventListener("submit", function (event) {
            console.log("Form id is ", this.id);

            let nameInputs = this.getElementsByClassName("validate_name");
            let addressInputs = this.getElementsByClassName("validate_address");
            let telephoneInputs = this.getElementsByClassName("validate_telephone");
            let zipcodeInputs = this.getElementsByClassName("validate_zipcode");

            let isValid =
                validateNames(nameInputs) &&
                validateAddresses(addressInputs) &&
                validateTelephones(telephoneInputs) &&
                validateZipcodes(zipcodeInputs);

            if (!isValid) {
                event.preventDefault();
                console.log("Form validation failed!");
            } else {
            }
        });
    });
});

function validateNames(inputs) {
    let nameRegex = /^[A-Za-z]{3,}$/;
    return validateInputs(inputs, nameRegex, "Invalid name! Only letters, spaces, ' and - (2-30 chars).");
}

function validateAddresses(inputs) {
    let addressRegex = /^[A-Za-z0-9\s-]+$/;
    return validateInputs(inputs, addressRegex, "Invalid street address! Min 5, max 100 characters.only - and spaces allowed");
}

function validateTelephones(inputs) {
    let telephoneRegex = /^[6-9]\d{9}$/;
    return validateInputs(inputs, telephoneRegex, "Invalid phone number! Must be exactly 10 digits starting digit must be between 6to 9.");
}

function validateZipcodes(inputs) {
    let zipcodeRegex = /^[1-9]\d{5}$/;
    return validateInputs(inputs, zipcodeRegex, "Invalid zip code! Must be 6 digits.");
}

function validateInputs(inputs, regex, errorMessage) {
    let isValid = true;

    Array.from(inputs).forEach((input) => {
        let value = input.value.trim();
        let errorMsg = input.nextElementSibling;

        if (!errorMsg || !errorMsg.classList.contains("error-message")) {
            errorMsg = document.createElement("span");
            errorMsg.classList.add("error-message");
            errorMsg.style.color = "red";
            input.parentNode.appendChild(errorMsg);
        }

        if (!regex.test(value)) {
            isValid = false;
            errorMsg.textContent = errorMessage;
        } else {
            errorMsg.textContent = "";
        }
    });

    return isValid;
}
