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

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

$('#recurring_check').click(function () {
  $('.recurring')[this.checked ? "show" : "hide"]();
});

var index = 0;

$(document).ready(function () {
  console.log("Adding");
  add();
});

function onInvoiceSubmit(e) {
  if (!checkAddingItems()) e.preventDefault();
}

function removeItem(index) {
  if (checkRemovingItems(index)) $(".error_space_" + index).parent().remove();
}

function checkRemovingItems(i) {
  if ($('.invoice_item').length === 1) {
    $(".error_space_" + i).addClass("alert alert-danger").text("You can't delete your only item.");
    return false;
  } else {
    $(".error_space_" + i).removeClass("alert alert-danger").text("");
    return true;
  }
}

function checkAddingItems() {
  var lastIndex = index - 1;
  var allowAdd = true;
  $('input[name^="item_details[' + lastIndex + ']"]').each(function () {
    if ($(this).val() == "") {
      $(".error_space_" + lastIndex).addClass("alert alert-danger").text("You must fill in this item before adding a new one or proceeding!");
      allowAdd = false;
    } else {
      $(".error_space_" + lastIndex).removeClass("alert alert-danger").text("");
    }
  });
  return allowAdd;
}

$("#add_invoice_item").click(function () {
  if (checkAddingItems()) add();
});

function add() {
  $('.invoice-items').append(template('#invoiceItemTemplate', {
    i: index
  }));
  index++;
}

function template(selector, params) {
  if (typeof params === 'undefined') {
    params = [];
  }

  var tplEl = $(selector);

  if (tplEl.length) {
    var tpl = $(selector).html();

    $.each(params, function (i, n) {
      tpl = tpl.replace(new RegExp("\\{" + i + "\\}", "g"), function () {
        if ((typeof n === 'undefined' ? 'undefined' : _typeof(n)) === 'object') {
          return n.get(0).outerHTML;
        } else {
          return n;
        }
      });
    });

    return $(tpl);
  } else {
    console.error('Template "' + selector + '" not found!');
  }
}

/***/ })

/******/ });