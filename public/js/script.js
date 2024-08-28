$(document).ready(function() {
    const leaderboardItems = document.querySelectorAll(".leaderboard-item");

    leaderboardItems.forEach((item, index) => {
    setTimeout(() => {
        item.classList.add("grow");
    }, index * 150);
    });
});

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
        return parts.pop().split(';').shift();
    }
    return null;
}

const pseudo = getCookie('pseudo');
console.log('Vérification du cookie pseudo:', pseudo);
