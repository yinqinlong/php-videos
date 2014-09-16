var Common = {
  iconfirm : function(text, redirect) {
    var html = '<div class="modal-content">'
             + '<div class="modal-body">'
             + '<button type="button" class="close" onclick="$.fancybox.close();"><span aria-hidden="true">×</span></button>'
             + '<h4>'+text+'</h4>'
             + '</div>'
             + '<div class="modal-footer">'
             + '<button class="btn btn-default" onclick="$.fancybox.close();">取消</button>'
             + '<button class="btn btn-danger" onclick="Common.click(\''+redirect+'\')">确定</button>'
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
  },
  click : function(link) {
    $.ajax({
      url : link,
    }).done(function(response, status) {
      $('body').html(response)
    });
  },
};
