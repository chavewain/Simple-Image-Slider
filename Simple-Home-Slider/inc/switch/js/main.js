(function() {
  var jQueryconfirm;

  jQueryconfirm = null;

  jQuery(function() {
    var jQuerycreateDestroy, jQuerywindow, sectionTop;
    jQuerywindow = jQuery(window);
    sectionTop = jQuery(".top").outerHeight() + 20;
    jQuerycreateDestroy = jQuery("#switch-create-destroy");
    hljs.initHighlightingOnLoad();
    jQuery("a[href*=\"#\"]").on("click", function(event) {
      var jQuerytarget;
      event.preventDefault();
      jQuerytarget = jQuery(jQuery(this).attr("href").slice("#"));
      if (jQuerytarget.length) {
        return jQuerywindow.scrollTop(jQuerytarget.offset().top - sectionTop);
      }
    });
    jQuery(".slide-plugon-settings input[type=\"checkbox\"], .slide-plugon-settings input[type=\"radio\"]").not("[data-switch-no-init]").bootstrapSwitch();
    jQuery("[data-switch-get]").on("click", function() {
      var type;
      type = jQuery(this).data("switch-get");
      return alert(jQuery("#switch-" + type).bootstrapSwitch(type));
    });
    jQuery("[data-switch-set]").on("click", function() {
      var type;
      type = jQuery(this).data("switch-set");
      return jQuery("#switch-" + type).bootstrapSwitch(type, jQuery(this).data("switch-value"));
    });
    jQuery("[data-switch-toggle]").on("click", function() {
      var type;
      type = jQuery(this).data("switch-toggle");
      return jQuery("#switch-" + type).bootstrapSwitch("toggle" + type.charAt(0).toUpperCase() + type.slice(1));
    });
    jQuery("[data-switch-set-value]").on("input", function(event) {
      var type, value;
      event.preventDefault();
      type = jQuery(this).data("switch-set-value");
      value = jQuery.trim(jQuery(this).val());
      if (jQuery(this).data("value") === value) {
        return;
      }
      return jQuery("#switch-" + type).bootstrapSwitch(type, value);
    });
    jQuery("[data-switch-create-destroy]").on("click", function() {
      var isSwitch;
      isSwitch = jQuerycreateDestroy.data("bootstrap-switch");
      jQuerycreateDestroy.bootstrapSwitch((isSwitch ? "destroy" : null));
      return jQuery(this).button((isSwitch ? "reset" : "destroy"));
    });
    return jQueryconfirm = jQuery("#confirm").bootstrapSwitch({
      size: "large",
      onSwitchChange: function(event, state) {
        event.preventDefault();
        return console.log(state, event.isDefaultPrevented());
      }
    });
  });

}).call(this);
