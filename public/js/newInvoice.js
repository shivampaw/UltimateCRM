$('#recurring_check').click(function() {
  $('.recurring')[this.checked ? "show" : "hide"]();
});

var index = 0;

$(document).ready(function(){
  console.log("Adding");
  add();
});

function onInvoiceSubmit(e){
  if(!checkAddingItems())
    e.preventDefault()
}

function removeItem(index){
  if(checkRemovingItems(index))
    $(".error_space_"+index).parent().remove();
}

function checkRemovingItems(i){
  if($('.invoice_item').length === 1){
    $(".error_space_"+i).addClass("alert alert-danger").text("You can't delete your only item.");
    return false;
  }else{
    $(".error_space_"+i).removeClass("alert alert-danger").text(""); 
    return true;
  }
}

function checkAddingItems(){
  var lastIndex = index - 1;
  var allowAdd = true;
  $('input[name^="item_details['+lastIndex+']"]').each(function() {
      if($(this).val() == ""){
        $(".error_space_"+lastIndex).addClass("alert alert-danger").text("You must fill in this item before adding a new one or proceeding!");
        allowAdd = false;
      }else{
       $(".error_space_"+lastIndex).removeClass("alert alert-danger").text(""); 
      }
  });
  return allowAdd;
}

$("#add_invoice_item").click(function(){
  if(checkAddingItems())
    add();
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