document.addEventListener("DOMContentLoaded", function() {
    var signupPopup = document.getElementById("signupPopup");
    var loginPopup = document.getElementById("loginPopup");
    var playButton = document.getElementById("playButton");
    var loginButton = document.getElementById("loginButton");
    var gotoLoginButton = document.getElementById("gotoLogin");
    var gotoRegisterButton = document.getElementById("gotoRegister");
    var closeButtons = document.getElementsByClassName("close");
    var colorOverlay = document.getElementById("colorOverlay2");
    var burgerMenu = document.getElementById("burgerMenu");
    var burgerSymbol = document.getElementById("burgerSymbol");
    var userLoggedIn = document.body.classList.contains("loggedIn");
    var questions = document.querySelectorAll('.question h3');
    var images = [
        'url("../assets/images/background.jpg")',
        'url("../assets/images/background1.jpg")',
        'url("../assets/images/background2.jpg")',
        'url("../assets/images/background3.jpg")',
        'url("../assets/images/background4.jpg")',
        'url("../assets/images/background5.jpg")',
    ];

    function changeBackgroundImage() {
        const homeElement = document.querySelector('body#home');
        if(homeElement) {
            const randomIndex = Math.floor(Math.random() * images.length);
            homeElement.style.backgroundImage = images[randomIndex];
            homeElement.style.backgroundSize = 'cover';
            homeElement.style.backgroundPosition = 'center';
        }
    }

    changeBackgroundImage();

    const changeBackgroundButton = document.getElementById('randomizer');
    if(changeBackgroundButton) {
        changeBackgroundButton.addEventListener('click', changeBackgroundImage);
    }

    if (loginButton) {
        loginButton.onclick = function() {
            if (userLoggedIn) {
                burgerMenu.classList.toggle("burgerMenuDisplay");
                burgerSymbol.classList.toggle('open');
            } else {
                loginPopup.style.display = "block";
                colorOverlay.style.display = "block";
            }
        };
    }

    if (playButton) {
        playButton.onclick = function() {
            if (userLoggedIn) {
                window.location.href = "/map.php";
            } else {
                signupPopup.style.display = "block";
                colorOverlay.style.display = "block";
            }
        };
    }

    if (gotoLoginButton) {
        gotoLoginButton.onclick = function() {
            signupPopup.style.display = "none";
            loginPopup.style.display = "block";
        };
    }

    if (gotoRegisterButton) {
        gotoRegisterButton.onclick = function() {
            signupPopup.style.display = "block";
            loginPopup.style.display = "none";
        };
    }

    for (var i = 0; i < closeButtons.length; i++) {
        closeButtons[i].onclick = function() {
            signupPopup.style.display = "none";
            loginPopup.style.display = "none";
            colorOverlay.style.display = "none";
        };
    }

    questions.forEach(function(question) {
        question.addEventListener('click', function() {
            const answer = this.parentElement.nextElementSibling;
            answer.classList.toggle('visible');
            this.classList.toggle('up');
        });
    });
});



/* window.onload = function() {
    var firstDiv = document.querySelector('.container'); 
    var secondDiv = document.querySelector('.container-shadow'); 
    
    var height = firstDiv.offsetHeight;
    secondDiv.style.height = height + 'px'; 
}; */