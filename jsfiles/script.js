// Countdown timer
const countdownElement = document.querySelector('.countdown');
const targetDate = new Date("Aug 18, 2024 22:00:00 GMT+0545").getTime();

function updateCountdown() {
    const now = new Date().getTime();
    const distance = targetDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `
        <span>${days}</span><span>DAYS</span>
        <span>${hours}</span><span>HOURS</span>
        <span>${minutes}</span><span>MINUTES</span>
        <span>${seconds}</span><span>SECONDS</span>
    `;

    if (distance < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "EXPIRED";
    }
}

const countdownInterval = setInterval(updateCountdown, 1000);
