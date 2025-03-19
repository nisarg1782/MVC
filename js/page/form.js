document.addEventListener("DOMContentLoaded", function () {
    setupFormValidation();
    observeDOMChanges();
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

    addRealTimeValidation(form);
}

function addRealTimeValidation(form) {
    let inputs = form.querySelectorAll("input[class^='validate_']");

    inputs.forEach((input) => {
        input.addEventListener("input", function () {
            let inputClasses = Array.from(input.classList).filter((cls) =>
                cls.startsWith("validate_")
            );
            if (inputClasses.length > 0) {
                inputClasses.forEach((inputClass) => {
                    if (typeof window[inputClass] === "function") {
                        window[inputClass](input);
                    } else {
                        console.log("No validation function found for:", inputClass);
                    }
                });
            }
        });
    });
}

function observeDOMChanges() {
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1) {
                    if (node.tagName === "FORM") {
                        attachValidationToForm(node);
                    } else {
                        let form = node.closest("form");
                        if (form) {
                            addRealTimeValidation(form);
                        }
                    }
                }
            });
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
}

function validate_name(input) {
    validateInput(
        input,
        /^[A-Za-z]{3,}$/,
        "Invalid name! Only letters (3+ chars).",
        "error-name."
    );
}

function validate_address(input) {
    validateInput(
        input,
        /^[A-Za-z0-9\s-]{5,100}$/,
        "Invalid address! Min 5, max 100 chars.",
        "error-address."
    );
}

function validate_telephone(input) {
    validateInput(
        input,
        /^[6-9]\d{9}$/,
        "Invalid phone number! Must be 10 digits, starting with 6-9.",
        "error-telephone."
    );
}

function validate_zipcode(input) {
    validateInput(
        input,
        /^[1-9]\d{5}$/,
        "Invalid zip code! Must be exactly 6 digits.",
        "error-zipcode."
    );
}

function validateInput(input, regex, errorMessage, errorClass) {
    let value = input.value.trim();
    let errorContainer = input.parentNode.querySelector(`.${errorClass}`);

    if (!errorContainer) {
        errorContainer = document.createElement("span");
        errorContainer.classList.add("error-message", errorClass);
        errorContainer.style.color = "red";
        input.parentNode.appendChild(errorContainer);
    }

    let isValid = regex.test(value);
    errorContainer.textContent = isValid ? "" : errorMessage;
}

function checkForErrors(form) {
    let errorMessages = form.getElementsByClassName("error-message");
    return Array.from(errorMessages).some(
        (span) => span.textContent.trim() !== ""
    );
}
