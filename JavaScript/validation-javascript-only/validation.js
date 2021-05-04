const subscription_form = document.getElementById("subscription-form");
const input_email       = document.getElementById("input-email");
const input_terms       = document.getElementById("input-terms");
const error_message     = document.getElementById("error-message");


function removeWhitespaces(str) {
    str = str.replace(/\s+/g, '');
    return str;
}


function isInputEmailEmpty(value) {
    return (value === '' || value == null);
}


function isInputEmailValid(str) {
    const rgxpattern = /^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/;
    return (rgxpattern.test(str));
}


function isDotCo(email) {
    return email.slice(-3) === ".co";
}


subscription_form.addEventListener('submit', (e) => {

    let errors = [];

    const input_email_value = removeWhitespaces(input_email.value);


    if (isInputEmailEmpty(input_email_value)) {
        errors.push('<div>* Email address is required</div>')
    } else if (!isInputEmailValid(input_email_value)) {
        errors.push('<div>* Please provide a valid e-mail address</div>')
    }

    if (isInputEmailValid(input_email_value) && isDotCo(input_email_value)) {
        errors.push('<div>* We are not accepting subscriptions from Colombia emails</div>')
    }

    if (input_terms.checked === false) {
        errors.push('<div>* You must accept the terms and conditions</div>')
    }

    if (errors.length > 0) {
        e.preventDefault()
        error_message.innerHTML = errors.join(' ')
    } else {
        e.preventDefault()  
        document.getElementById("content-subscribe-outer").style.display = "none";
        document.getElementById("content-thanks-outer").style.display = "block";
    }

});