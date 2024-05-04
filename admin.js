function generateCalendar() {
    var calendarDiv = document.getElementById('miniCalendar');
    var currentDate = new Date();
    var currentDay = currentDate.getDate();
    var currentMonth = currentDate.getMonth();
    var currentYear = currentDate.getFullYear();
    var daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    var firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
    var weekRow = document.createElement('div');
    weekRow.classList.add('week-row');
    calendarDiv.innerHTML = '';

    // Generate days of the week headers
    var daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    daysOfWeek.forEach(function(day) {
        var dayHeader = document.createElement('div');
        dayHeader.classList.add('day');
        dayHeader.textContent = day;
        weekRow.appendChild(dayHeader);
    });
    calendarDiv.appendChild(weekRow);

    // Generate days of the month
    var dayCount = 1;
    for (var i = 0; i < 6; i++) { // Max 6 rows
        var weekRow = document.createElement('div');
        weekRow.classList.add('week-row');
        for (var j = 0; j < 7; j++) {
            var dayCell = document.createElement('div');
            dayCell.classList.add('day');
            if ((i === 0 && j < firstDayOfMonth) || dayCount > daysInMonth) {
                dayCell.textContent = '';
                dayCell.classList.add('inactive');
            } else {
                dayCell.textContent = dayCount;
                if (dayCount === currentDay) {
                    dayCell.classList.add('currentDay');
                }
                dayCount++;
            }
            weekRow.appendChild(dayCell);
        }
        calendarDiv.appendChild(weekRow);
    }
}

// Call the function to generate the calendar
generateCalendar();
const menuToggle = document.querySelector('.menu-toggle');
// Get the side bar
const sideBar = document.querySelector('.side-bar');

// Add event listener for menu toggle button
menuToggle.addEventListener('click', function() {
    // Toggle the 'active' class on the side bar
    sideBar.classList.toggle('active');
});