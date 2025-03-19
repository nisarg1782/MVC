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
            }
        });

        addRealTimeValidation(
            form,
            "validate_name",
            /^[A-Za-z]{3,}$/,
            "Invalid name! Only letters (3+ chars)."
        );
        addRealTimeValidation(
            form,
            "validate_address",
            /^[A-Za-z0-9\s-]+$/,
            "Invalid address! Min 5, max 100 characters. Only - and spaces allowed."
        );
        addRealTimeValidation(
            form,
            "validate_telephone",
            /^[6-9]\d{9}$/,
            "Invalid phone number! Must be exactly 10 digits, starting with 6-9."
        );
        addRealTimeValidation(
            form,
            "validate_zipcode",
            /^[1-9]\d{5}$/,
            "Invalid zip code! Must be 6 digits."
        );
    });
});

function addRealTimeValidation(form, className, regex, errorMessage) {
    let inputs = form.getElementsByClassName(className);

    Array.from(inputs).forEach((input) => {
        input.addEventListener("input", function () {
            validateInput(this, regex, errorMessage);
        });
    });
}

function validateInput(input, regex, errorMessage) {
    let value = input.value.trim();
    let errorMsg = input.nextElementSibling;

    if (!errorMsg || !errorMsg.classList.contains("error-message")) {
        errorMsg = document.createElement("span");
        errorMsg.classList.add("error-message");
        errorMsg.style.color = "red";
        input.parentNode.appendChild(errorMsg);
    }

    if (!regex.test(value)) {
        errorMsg.textContent = errorMessage;
    } else {
        errorMsg.textContent = "";
    }
}

// function validateNames(inputs) {
//     return validateInputs(inputs, /^[A-Za-z]{3,}$/, "Invalid name! Only letters (3+ chars).");
// }

// function validateAddresses(inputs) {
//     return validateInputs(inputs, /^[A-Za-z0-9\s-]+$/, "Invalid address! Min 5, max 100 characters. Only - and spaces allowed.");
// }

// function validateTelephones(inputs) {
//     return validateInputs(inputs, /^[6-9]\d{9}$/, "Invalid phone number! Must be exactly 10 digits, starting with 6-9.");
// }

// function validateZipcodes(inputs) {
//     return validateInputs(inputs, /^[1-9]\d{5}$/, "Invalid zip code! Must be 6 digits.");
// }

// function validateInputs(inputs, regex, errorMessage) {
//     let isValid = true;

//     Array.from(inputs).forEach((input) => {
//         if (!validateInput(input, regex, errorMessage)) {
//             isValid = false;
//         }
//     });

//     return isValid;
// }
