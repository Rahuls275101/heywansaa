
function incDnc(val, qid, avaQty) {
  qval = jQuery('#qty_' + qid).val();
  mqval = jQuery('#mqty_' + qid).val();
  // alert(qid); return false;
  var i = eval(qval);
  if (val === 1) {
    if (avaQty > i) {
      i++;
      jQuery('#qty_' + qid).val(i);
      jQuery('#mqty_' + qid).val(i);
      jQuery.post(site_url + 'cart/update_cart_qty', $('#cart_frm').serialize(), function (data) {
        location.reload();
        //console.log(data);
        //alert(data.error_msg);
        // $("#cart_frm").load('#cart_frm');
        //jQuery('#crt_msg').validationEngine('showPrompt', data.error_msg, data.error_type, true);
      }, 'json');
    }
    else {
      alert('Quantity can not excced '+avaQty);
      //jQuery('#mqty_' + qid).validationEngine('showPrompt', 'Quantity can not excced ' + avaQty, 'error', true);
    }
  }
  else if (val === 2) {
    if (i > 1) {
      i--;
      jQuery('#qty_' + qid).val(i);
      jQuery('#mqty_' + qid).val(i);
      jQuery.post(site_url + 'cart/update_cart_qty', $('#cart_frm').serialize(), function (data) {
        location.reload();
        //console.log(data);
        //jQuery('#crt_msg').validationEngine('showPrompt', data.error_msg, data.error_type, true);
      }, 'json');
    }
    else {
      alert('Quantity can not less than 1');
      //jQuery('#mqty_' + qid).validationEngine('showPrompt', 'Quantity can not less then 1', 'error', true);
    }
  }
}

