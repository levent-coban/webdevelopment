function isInputEmailValid(str) {
    const rgxpattern = /^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/;
    return (rgxpattern.test(str));
}


function isDotCo(email) {
    return email.slice(-3) === ".co";
}


const app = new Vue({
  el: '#subscription-form',
  data: {
    errors: [],
    input_email: null,
    input_terms: null,
  },
  methods:{

    checkForm: function (e) {

        this.errors = [];

        if (!this.input_email) {
            this.errors.push('* Email address is required');
        } else if (!isInputEmailValid(this.input_email)) {
            this.errors.push('* Please provide a valid e-mail address');
        }

        if (isInputEmailValid(this.input_email) && isDotCo(this.input_email)) {
            this.errors.push('* We are not accepting subscriptions from Colombia emails');
        }

        if (!this.input_terms) {
            this.errors.push('* You must accept the terms and conditions');
        }


        if (this.errors.length > 0) {
            e.preventDefault();
        } else { 
            e.preventDefault(); 
            document.getElementById("content-subscribe-outer").style.display = "none";
            document.getElementById("content-thanks-outer").style.display = "block";
        }
    }

  }
});