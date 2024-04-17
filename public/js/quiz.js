$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const level = urlParams.get('level') || '1';
    let currentQuestionIndex = 0;
    let score = 0;
    let timerExpired = false;
    let startTime;
    let questions = [];

    function startLevel(level) {
        $('.level-info').hide();
        $('.level-content').show();
    
        switch (level) {
            case '2':
                console.log('Lancement du DevineFilm pour le niveau 2');
                break;
            case '3':
            case '7':
                console.log('Starting Matching Game for level 3 or 7');
                break;
            case '5':
                console.log('Lancement du Wordle pour le niveau 5');
                break;
            default:
                if (questions.length > 0) {
                    displayQuestion(questions, currentQuestionIndex);
                }
                break;
        }
    }

    function loadInfo(level) {
        $.ajax({
            url: '../php/get_data.php',
            type: 'POST',
            data: { level },
            success: function(response) {
                const data = JSON.parse(response);
                questions = data.questions;
                if (questions.length > 8) {
                    questions = shuffleArray(questions).slice(0, 8);
                }
                displayLevelDetails(data.levelDetails);
                $('#startLevel').on('click', function() {
                    startLevel(level);
                });
                updateQuestionCounter(currentQuestionIndex + 1, questions.length);
            }
        });
    }

    loadInfo(level);

    function displayLevelDetails(levelDetails) {
        $('#level-name').text(levelDetails.name);
        $('#level-explanation').text(levelDetails.explanation);
        $('.level-content').hide();
        $('.level-info').show();
    }
    
    function endLevel() {
        sendScoreToServer(score);
        var nextLevel = parseInt(level) + 1;
        $('.question-container').html('<h3>Félicitations, tu as terminé ce niveau avec un score de ' + score + ' points!</h3>' +
            '<button class="default"><a href="/quiz.php?level=' + nextLevel + '">Passer à la salle ' + nextLevel + '</a></button>'
            );
        return;
    }
    
    function displayQuestion(questions, currentQuestionIndex) {
        if (currentQuestionIndex >= questions.length) {
            endLevel();
        }

        startTime = Date.now();
        timerExpired = false;
        setTimeout(function() {
            timerExpired = true;
        }, 12000);

        updateQuestionCounter(currentQuestionIndex + 1, questions.length);

        $('.kernel').removeClass('current');

        var question = questions[currentQuestionIndex];
        var options = [question.option_a, question.option_b, question.option_c, question.option_d];
        shuffleArray(options);

        if(level === '8') {
            options = [question.option_c, question.option_d]; 
            options = options.filter(option => option.trim() !== '');
        }

        $('#question').text(question.question);

        var optionsHtml = '';
        options.forEach(function(option) {
            optionsHtml += '<li>' + option + '</li>';
        });
        $('#options').html(optionsHtml);

        $('#options li').each(function(index) {
            $(this).data('isCorrect', options[index] === question.option_d);
        }).on('click', function() {
            handleOptionSelection($(this), questions, currentQuestionIndex);
        });

        $('#qst-' + (currentQuestionIndex + 1)).addClass('current');
    }

    function handleOptionSelection(selectedOption, questions, currentQuestionIndex) {
        var isCorrect = selectedOption.data('isCorrect');
        $('#options li').removeClass('correct incorrect unselected no-hover').off('click');
        
        var elapsedTime = Date.now() - startTime; 
        var points = isCorrect && !timerExpired ? calculatePoints(elapsedTime) : 10;
        if (isCorrect) {
            score += points;
            selectedOption.addClass('correct');
            $('#options li').not(selectedOption).addClass('unselected');
            $('#qst-' + (currentQuestionIndex + 1)).addClass('right');
        } else {
            selectedOption.addClass('incorrect');
            $('#options li').each(function() {
                if ($(this).data('isCorrect')) {
                    $(this).addClass('correct');
                } else if (!$(this).is(selectedOption)) {
                    $(this).addClass('unselected');
                }
            });
            $('#qst-' + (currentQuestionIndex + 1)).addClass('wrong');
        }
    
        $('.question-container').addClass('no-hover');

        setTimeout(function() {
            displayQuestion(questions, currentQuestionIndex + 1);
        }, 2500);        
    }

    function calculatePoints(elapsedTime) {
        return Math.max(10, 50 - Math.floor(elapsedTime / 1000 / 12 * 40));
    }

    function shuffleArray(array) {
        for (var i = array.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] =  [array[j], array[i]];
        }
        return array;
    }

    function updateQuestionCounter(current, total) {
        $('.counter p').text(current + '/' + total);
    }

    function sendScoreToServer(score) {
        $.ajax({
            url: '../php/update_progress.php',
            type: 'POST',
            data: {
                level: level,
                score: score
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de l'envoi du score: ", error);
            }
        });
    }
});