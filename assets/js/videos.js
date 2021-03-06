// Generated by CoffeeScript 1.6.1
(function() {

  $(document).ready(function() {
    var maxHeight, value;
    maxHeight = 0;
    $('.sortable').find('.thumbnail').each(function() {
      if ($(this).height() + 200 > maxHeight) {
        return maxHeight = $(this).height() + 200;
      }
    });
    $('.sortable').find('.thumbnail').height(maxHeight);
    $('.sortable').sortable({
      stop: function(event, ui) {
        var data, i;
        i = 0;
        data = {};
        $('.video').each(function() {
          data[i] = $(this).attr('id');
          return i++;
        });
        return $.post('videos/sort', {
          'sort': data
        });
      }
    });
    value = $('#photo_id').val();
    $('#' + value).addClass('ui-selected click-selected');
    return $('.selectable').selectable({
      filter: 'li',
      selected: function(event, ui) {
        if ($(ui.selected).hasClass("click-selected")) {
          $(ui.selected).removeClass("ui-selected click-selected");
          return $('#photo_id').val("");
        } else {
          $(ui.selected).addClass("click-selected");
          return $('#photo_id').val($(ui.selected).attr('id'));
        }
      },
      unselected: function(event, ui) {
        return $(ui.unselected).removeClass("click-selected");
      }
    });
  });

}).call(this);
