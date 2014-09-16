$(document).ready(function(){
  $("#date_begin").datetimepicker({
    format: "yyyy-mm-dd",
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
  });
  $("#date_end").datetimepicker({
    format: "yyyy-mm-dd",
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
  });
});

var Datepicker = {
  change : function() {
    var dateBegin = $('#date_begin').val();
    var dateEnd = $('#date_end').val();
    if(dateBegin != '' && dateEnd != '') {
      if(dateEnd < dateBegin) {
        var html = '<div class="modal-content">'
                 + '<div class="modal-body">'
                 + '<button type="button" class="close" onclick="$.fancybox.close();"><span aria-hidden="true">×</span></button>'
                 + '<h4>开始时间不能晚于结束时间</h4>'
                 + '</div>'
                 + '<div class="modal-footer">'
                 + '<button class="btn btn-primary" onclick="$.fancybox.close();">确定</button>'
                 + '</div></div>'
        $.fancybox({
          'padding' : 0,
          'topRatio': 0.2,
          'autoSize': false,
          'width': '400px',
          'height': '136px',
          'closeBtn' : false,
          'content': html,
        });
        return false;
      }
    }
  },
}
