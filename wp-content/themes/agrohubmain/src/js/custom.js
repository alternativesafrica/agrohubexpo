(() => {
    // Specify the deadline date
    const deadlineDate = new Date('November 27, 2020 23:59:59').getTime();

    // Cache all countdown boxes into consts
    const countdownDays = document.querySelector('.ag-countdown-days .number');
    const countdownHours = document.querySelector('.ag-countdown-hours .number');
    const countdownMinutes = document.querySelector('.ag-countdown-minutes .number');
    const countdownSeconds = document.querySelector('.ag-countdown-seconds .number');

    // Update the count down every 1 second (1000 milliseconds)
    setInterval(() => {
        // Get current date and time
        const currentDate = new Date().getTime();

        // Calculate the distance between current date and time and the deadline date and time
        const distance = deadlineDate - currentDate;

        // Calculations the data for remaining days, hours, minutes and seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Insert the result data into individual countdown boxes
        countdownDays.innerHTML = days;
        countdownHours.innerHTML = hours;
        countdownMinutes.innerHTML = minutes;
        countdownSeconds.innerHTML = seconds;
    }, 1000);
})();