!function(n){"use strict";window.wsf_admin_wp_count_submit_unread_ajax=function(){n.getJSON(ws_form_admin_count_submit_read_settings.count_submit_unread_ajax_url,function(n){if(n)var _=void 0!==n.count_submit_unread_total?n.count_submit_unread_total:0;else _=0;wsf_admin_wp_count_submit_unread_render(_)})},window.wsf_admin_wp_count_submit_unread_render=function(_){if(void 0===_)_=0;else _=parseInt(_,10);var t=_>0?' <span class="count-'+_+'" title="'+_+" new submission"+(1!=_?"s":"")+'"><span class="update-count">'+_+"</span></span>":"";n(".wsf-submit-unread-total").html(t)},n(function(){window.wsf_admin_wp_count_submit_unread_render(ws_form_admin_count_submit_read_settings.count_submit_unread_total)})}(jQuery);