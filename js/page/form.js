document.addEventListener("DOMContentLoaded", function () {
    const observer = new MutationObserver(handleMutations);

    setupFormValidation();
});

function setupFormValidation() {
    let forms = document.getElementsByTagName("form");
    Array.from(forms).forEach((form) => {
        attachValidationToForm(form);
    });
}

function attachValidationToForm(form) {

    form.addEventListener("submit", function (event) {
        let hasErrors = checkForErrors(form);
        if (hasErrors) {
            event.preventDefault();
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
}

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

    let isValid = regex.test(value);
    errorMsg.textContent = isValid ? "" : errorMessage;
}


function checkForErrors(form) {
    let errorMessages = form.getElementsByClassName("error-message");
    return Array.from(errorMessages).some((span) => span.textContent.trim() !== "");
}

function handleMutations(mutations) {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.nodeType === 1) {
                if (node.tagName === "FORM") {
                    attachValidationToForm(node);
                } else {
                    let form = node.closest("form");
                    if (form) {
                        setupFormValidation();
                    }
                }
            }
        });
    });
}
