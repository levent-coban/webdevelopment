# JavaScript

Based on previous part (UI) was created subscription input validation.
- An error message appears under input that shows validation messages if:
        - Invalid email is added - “Please provide a valid e-mail address”
        - The checkbox is not marked - “You must accept the terms and conditions”
        - No email address is provided - “Email address is required”
        - Provided email is ending with .co - “We are not accepting subscriptions with .co TLD.

- Once validation has passed, the error disappears.
- The button is disabled if the form is not valid.
- On successful validation, a success message appears in the place of the form, as per design.

This JavaScript implemantation have been created with only JavaScript and also with Vue.js