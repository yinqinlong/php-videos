var Video = {
  bindFancybox : function() {
    $('[name="edit"]').click(function() {
      $.fancybox({
        'padding' : 0,
        'autoSize': false,
        'width' : '800px',
        'height' : '320px',
        'type' : 'iframe',
        'closeBtn' : false,
        'href' : $(this).attr('data-link')
      });
    });
  },
};
