<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chance/1.0.13/chance.min.js"></script>
<script src="COMPLEMENTOS/CALENDARIO/JS/tui-calendar.js"></script>

<script src="COMPLEMENTOS/CALENDARIO/JS/data/calendars.js"></script>
<script src="COMPLEMENTOS/CALENDARIO/JS/data/schedules.js"></script>

<script type="text/javascript" class="code-js">

  // register templates
  const templates = {
    popupDetailDate: function(isAllDay, start, end) {
      var isSameDate = moment(start).isSame(end);
      var endFormat = (isSameDate ? '' : 'DD/MM/YYYY ') + 'hh:mm a';

      if (isAllDay) {
        return moment(start).format('DD/MM/YYYY') + (isSameDate ? '' : ' - ' + moment(end).format('DD/MM/YYYY'));
      }

      return (moment(start).format('DD/MM/YYYY hh:mm a') + ' - ' + moment(end).format(endFormat));
    },
    popupDetailLocation: function(schedule) {
      return 'Localização : ' + schedule.location;
    },
    popupDetailUser: function(schedule) {
      return 'Usuário : ' + (schedule.attendees || []).join(', ');
    },
    popupEdit: function() {
      return 'Edit';
    },
    popupDelete: function() {
      return 'Delete';
    }
  };

  var cal = new tui.Calendar('#calendar', {
    defaultView: 'month',
    template: templates,
    useDetailPopup: true
  });
</script>
<script src="COMPLEMENTOS/CALENDARIO/JS/default.js"></script>