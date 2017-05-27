new Vue({
  el: "#newInvoice",

  data: {
    invoiceItems: [
      {
        description: null,
        quantity: null,
        price: null,
      }
    ],
    due_date: null,
    project_id: null,
    recurring_date: null,
    recurring_due_date: null,
    notes: null,
    recurringChecked: false,
    errors: [],
  },

  methods: {
    addInvoiceItem(e) {

      if(this.canAddItemOrProceed()) {
        this.invoiceItems.push({
          description: null,
          quantity: null,
          price: null,
        });
      }
    },

    submitForm(e) {
      if(!this.canAddItemOrProceed()) {
        return;
      } else {
        axios.post(e.target.action, this.$data)
            .then(success => window.location.href = "../invoices")
            .catch(failure => {
              if (failure.response.status >= 500) {
                this.errors.push("Something weird went wrong...Please try again later or contact the admin.");
              } else {
                var errorsArray = failure.response.data;
                Object.keys(errorsArray).forEach(error => {
                  this.errors.push(errorsArray[error][0]);
                });
              }
            });
      }
    },

    canAddItemOrProceed() {
      this.errors = [];
      var canAdd = true;
      
      this.invoiceItems.forEach(function(item) {
        if(!item.description || !item.quantity || !item.price) {
          canAdd = false;
          return;
        }
      });

      if(!canAdd) {
        this.errors.push("You must complete all existing invoice items before adding a new one or proceeding");
      }

      return canAdd;
    },

    removeInvoiceItem(itemIndex) {
      this.errors = [];
      if (this.invoiceItems.length > 1) {
        this.invoiceItems.splice(itemIndex, 1);
      } else {
        this.errors.push("You cannot remove your only item");
      }
    },
  },

});