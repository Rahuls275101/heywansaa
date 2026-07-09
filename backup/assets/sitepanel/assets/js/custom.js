/*
 =========================================
 |                                       |
 |           Scroll To Top               |
 |                                       |
 =========================================
 */
$('.scrollTop').click(function () {
  $("html, body").animate({scrollTop: 0});
});


$('.navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ').click(function (e) {
  e.stopPropagation();
});

/*
 =========================================
 |                                       |
 |       Multi-Check checkbox            |
 |                                       |
 =========================================
 */

function checkall(clickchk, relChkbox) {

  var checker = $('#' + clickchk);
  var multichk = $('.' + relChkbox);


  checker.click(function () {
    multichk.prop('checked', $(this).prop('checked'));
  });
}


/*
 =========================================
 |                                       |
 |           MultiCheck                  |
 |                                       |
 =========================================
 */

/*
 This MultiCheck Function is recommanded for datatable
 */

function multiCheck(tb_var) {
  tb_var.on("change", ".chk-parent", function () {
    var e = $(this).closest("table").find("td:first-child .child-chk"), a = $(this).is(":checked");
    $(e).each(function () {
      a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
    })
  }),
          tb_var.on("change", "tbody tr .new-control", function () {
            $(this).parents("tr").toggleClass("active")
          })
}

/*
 =========================================
 |                                       |
 |           MultiCheck                  |
 |                                       |
 =========================================
 */

function checkall(clickchk, relChkbox) {

  var checker = $('#' + clickchk);
  var multichk = $('.' + relChkbox);


  checker.click(function () {
    multichk.prop('checked', $(this).prop('checked'));
  });
}

/*
 =========================================
 |                                       |
 |               Tooltips                |
 |                                       |
 =========================================
 */

$('.bs-tooltip').tooltip();

/*
 =========================================
 |                                       |
 |               Popovers                |
 |                                       |
 =========================================
 */

$('.bs-popover').popover();


/*
 ================================================
 |                                              |
 |               Rounded Tooltip                |
 |                                              |
 ================================================
 */

$('.t-dot').tooltip({
  template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})


/*
 ================================================
 |            IE VERSION Dector                 |
 ================================================
 */

function GetIEVersion() {
  var sAgent = window.navigator.userAgent;
  var Idx = sAgent.indexOf("MSIE");

  // If IE, return version number.
  if (Idx > 0)
    return parseInt(sAgent.substring(Idx + 5, sAgent.indexOf(".", Idx)));

  // If IE 11 then look for Updated user agent string.
  else if (!!navigator.userAgent.match(/Trident\/7\./))
    return 11;

  else
    return 0; //It is not IE
}


function validcheckstatus(name, action, text, formId) {
  var chObj = document.getElementsByName(name);
  var result = false;
  for (var i = 0; i < chObj.length; i++) {

    if (chObj[i].checked) {
      result = true;
      break;
    }
  }
  if (!result) {
    swal({
      title: "Please select atleast one " + text + " to " + action + ".",
      padding: '2em'
    });
    return false;
  } else if (action == 'Delete' || action == 'Deactivate' || action == 'Deactivate Membership') {
    swal({
      title: 'Are you sure?',
      text: "You want to " + action + "!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: action,
      padding: '2em'
    }).then(function (result) {
      if (result.value) {
        $('#actionInput').val(action);
        $('#' + formId).submit();
      }
    });
    return false;
  } else {
    $('#actionInput').val(action);
    $('#' + formId).submit();
    return true;
  }
}


$(".toggle-status").click(function () {
  var obj = this;
  var userId = $(this).attr('data-userId');
  var status = $(this).attr('data-status');
  var controller = $(this).attr('data-controller');
  if (userId > 0) {
    $.post(admin_url + '/' + controller + '/updateuserstatus', {userId: userId, status: status}, function (response) {
      if (status == '1') { //Activated
        $(obj).attr('data-status', '0');
        $(obj).parent().removeClass('s-deactive');
        $(obj).parent().addClass('s-active');
      } else { //Deactivated
        $(obj).attr('data-status', '1');
        $(obj).parent().removeClass('s-active');
        $(obj).parent().addClass('s-deactive');
      }
      swal({
        title: response,
        padding: '2em'
      });
    });
  }
});


//SEO URL Creation - VIC
$(document).ready(function () {

  function get_seo_url(e) {
    var prev_url_val = "";
    var ws_alert_prompt = 0;
    target_obj = e.target;
    target_obj = $(target_obj);
    changeable_obj = $('.seo_friendly_url');
    pg_title = target_obj.val();
    pg_title = $.trim(pg_title);
    if (pg_title != '') {
      $('#error_url_creator').html('');
      current_url_val = pg_title;
      if (prev_url_val != current_url_val) {
        prev_url_val = current_url_val;
        pre_seo_url_obj = $('#pre_seo_url');
        pre_title = pre_seo_url_obj.length ? pre_seo_url_obj.val() : "";
        pre_title = $.trim(pre_title);
        rec_obj = $('#pg_recid');
        rec_id = rec_obj.length ? rec_obj.val() : "";
        rec_id = $.trim(rec_id);
        $.post(base_url + 'seo/create_seo_url', {title: pg_title, pre_title: pre_title, rec_id: rec_id}, function (data) {
          if (data.error) {
            $('#error_friendly_url').html(data.msg);
            $("button").prop("disabled", true);
          } else {
            $('#error_friendly_url').html('');
            $("button").prop("disabled", false)
          }
          changeable_obj.val(data.friendly_name);
        }, "json");
      }
    } else {
      if (ws_alert_prompt == 1) {
        $('#error_url_creator').html('Please enter ' + target_obj.attr('placeholder'));
        //target_obj.focus();
      }
    }
  }
  $('.url_creator').bind('blur', get_seo_url);

  $('.change_url').click(function (e) {
    e.preventDefault();
    $(this).hide();
    ws_alert_prompt = 0;
    $('.seo_friendly_url').attr('readonly', false);
    $('.url_creator').unbind('blur');
    $('.seo_friendly_url').bind('blur', get_seo_url);
  });
  $('.url_from_title').click(function (e) {
    e.preventDefault();
    ws_alert_prompt = 1;
    $('.change_url').show();
    $('.seo_friendly_url').attr('readonly', true).unbind('blur');
    $('.url_creator').bind('blur', get_seo_url).trigger('blur');
  });
  $('.edit_url').bind('blur', get_seo_url);
});
