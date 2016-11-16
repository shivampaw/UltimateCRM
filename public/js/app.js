$("#add_invoice_item").click(function(){
    add();
});

var index = 1;
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

    $.each(params, function(i, n) {
      tpl = tpl.replace(new RegExp("\\{" + i + "\\}", "g"), function() {
        if (typeof n === 'object') {
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