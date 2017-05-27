/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ({

/***/ 11:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(2);


/***/ }),

/***/ 2:
/***/ (function(module, exports) {

new Vue({
  el: "#newInvoice",

  data: {
    invoiceItems: [{
      description: null,
      quantity: null,
      price: null
    }],
    due_date: null,
    project_id: null,
    recurring_date: null,
    recurring_due_date: null,
    notes: null,
    recurringChecked: false,
    errors: []
  },

  methods: {
    addInvoiceItem: function addInvoiceItem(e) {

      if (this.canAddItemOrProceed()) {
        this.invoiceItems.push({
          description: null,
          quantity: null,
          price: null
        });
      }
    },
    submitForm: function submitForm(e) {
      var _this = this;

      if (!this.canAddItemOrProceed()) {
        return;
      } else {
        axios.post(e.target.action, this.$data).then(function (success) {
          return window.location.href = "../invoices";
        }).catch(function (failure) {
          if (failure.response.status >= 500) {
            _this.errors.push("Something weird went wrong...Please try again later or contact the admin.");
          } else {
            var errorsArray = failure.response.data;
            Object.keys(errorsArray).forEach(function (error) {
              _this.errors.push(errorsArray[error][0]);
            });
          }
        });
      }
    },
    canAddItemOrProceed: function canAddItemOrProceed() {
      this.errors = [];
      var canAdd = true;

      this.invoiceItems.forEach(function (item) {
        if (!item.description || !item.quantity || !item.price) {
          canAdd = false;
          return;
        }
      });

      if (!canAdd) {
        this.errors.push("You must complete all existing invoice items before adding a new one or proceeding");
      }

      return canAdd;
    },
    removeInvoiceItem: function removeInvoiceItem(itemIndex) {
      this.errors = [];
      if (this.invoiceItems.length > 1) {
        this.invoiceItems.splice(itemIndex, 1);
      } else {
        this.errors.push("You cannot remove your only item");
      }
    }
  }

});

/***/ })

/******/ });