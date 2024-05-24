document.addEventListener('DOMContentLoaded', function() {
    /*function changeBackgroundImage() {
        const homeElement = document.querySelector('body#home');
        if (homeElement) {
            const images = [
                'url("/images/background.jpg")',
                'url("/images/background1.jpg")',
                'url("/images/background2.jpg")',
                'url("/images/background3.jpg")',
                'url("/images/background4.jpg")',
                'url("/images/background5.jpg")',
            ];
            const randomIndex = Math.floor(Math.random() * images.length);
            homeElement.style.backgroundImage = images[randomIndex];
            homeElement.style.backgroundSize = 'cover';
            homeElement.style.backgroundPosition = 'center';
        }
    }
    
    changeBackgroundImage();*/

    questions.forEach(function(question) {
        question.addEventListener('click', function() {
            const answer = this.parentElement.nextElementSibling;
            answer.classList.toggle('visible');
            this.classList.toggle('up');
        });
    });

    function removeAllClasses() {
        var element = document.querySelector("#registerModal > div > div > div.modal-body > div > div:nth-child(2)");
        if (element) {
            element.className = '';
        } else {
            console.log('Element not found');
        }
    }
    
    removeAllClasses();    
});
