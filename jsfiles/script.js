// JavaScript for countdown timer
const countdownElement = document.querySelector('.countdown');
const targetDate = new Date("Aug 18, 2024 22:00:00").getTime();

function updateCountdown() {
    const now = new Date().getTime();
    const distance = targetDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `
        <span>${days} DAYS</span>
        <span>${hours} HOURS</span>
        <span>${minutes} MINUTES</span>
        <span>${seconds} SECONDS</span>
    `;

    if (distance < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "EXPIRED";
    }
}

const countdownInterval = setInterval(updateCountdown, 1000);
