$(document).ready(function() {
    let dateInput = $('#date');
    if (dateInput.length > 0) {
        dateInput.datepicker({
            dateFormat: 'yy-mm-dd'
        });
    }

    let timeInput = $('#time');
    if(timeInput.length > 0) {
        timeInput.timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '0',
            maxTime: '23:00',
            startTime: '1',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    }
});