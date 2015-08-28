<script type="text/javascript">

$(function(){
  var ajax = {
    //initialize
    init:function(){     
      //links
      $('[data-ajax]:not(form)').live('click', function(){
        $.get($(this).attr('data-ajax'), function(data) {
          ajax.execute(data);
        });
        return false;
      });
      
      //forms
      this.bind_forms();
    },
    bind_forms:function(){
      $('form[data-ajax]').unbind().bind('submit', function(){
        $.post($(this).attr('data-ajax'), $(this).serialize(), function(data) {
          ajax.execute(data);
        });
        return false;
      });
    },
    //execute
    execute:function(data){
      $('<div>'+data+'</div>').find('.action').each(function() {
        switch($(this).attr('type')) {
          case 'show':
            var select = ajax.select($(this).attr('data'));
            select.html($(this).html());
            select.show();
            break;
          case 'hide':
            var select = ajax.select($(this).attr('data'));
            select.hide();
            break;
          case 'append':
            var select = ajax.select($(this).attr('data'));
            select.append($(this).html());
            break;
          case 'prepend':
            var select = ajax.select($(this).attr('data'));
            select.prepend($(this).html());
            break;
        }
      });
      ajax.bind_forms();
    },
    select:function(string){
      var data = $.parseJSON(string);
      var sel = '';
      for (var i in data) {
        if (i != 'ajax') {
          sel += '[data-' + i + '="' + data[i] + '"]';
        }
      }
      return $(sel);
    }
  }
  
  ajax.init();
  
});
  
</script>
