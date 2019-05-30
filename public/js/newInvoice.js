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
/******/ 	return __webpack_require__(__webpack_require__.s = 40);
/******/ })
/************************************************************************/
/******/ ({

/***/ 11:
/***/ (function(module, exports) {

new Vue({
    el: "#newInvoice",

    data: {
        item_details: [{
            description: null,
            quantity: null,
            price: null
        }],
        due_date: null,
        project_id: null,
        notes: null,
        discount: null,
        how_often: null,
        next_run: null,
        errors: []
    },

    methods: {
        addInvoiceItem: function addInvoiceItem(e) {

            if (this.canAddItemOrProceed()) {
                this.item_details.push({
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
                    return window.location.href = e.target.action;
                }).catch(function (failure) {
                    if (failure.response.status >= 500) {
                        _this.errors.push(failure.response.data.message);
                    } else {
                        var errorsArray = failure.response.data.errors;
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

            this.item_details.forEach(function (item) {
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
            if (this.item_details.length > 1) {
                this.item_details.splice(itemIndex, 1);
            } else {
                this.errors.push("You cannot remove your only item");
            }
        }
    },

    created: function created() {
        var name = "project_id";
        var url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        this.project_id = decodeURIComponent(results[2].replace(/\+/g, " "));
        console.log(this.project_id);
    }
});

/***/ }),

/***/ 40:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(11);


/***/ })

/******/ });