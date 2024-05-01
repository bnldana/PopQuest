$(document).ready(function() {
    // Initialization
    let levelId = new URLSearchParams(window.location.search).get('level') || 1;
    let currentQuestionIndex = 0;
    let score = 0;
    let questions = [];
    let timerExpired = false;
    let timer;

    // Variable to hold the start time of the current question
    let startTime;

    // Display level details and load initial data
    loadInfo(levelId);

    // Load level information and questions
    function loadInfo(level) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/quiz/load-info',
            type: 'GET',
            data: { level: level },
            success: function(response) {
                displayLevelDetails(response.levelDetails);
                questions = shuffleArray(response.questions);
                startLevel();
            },
            error: function(error) {
                console.error('Error loading level info:', error);
            }
        });
    }

    // Display level details
    function displayLevelDetails(details) {
        $('#level-name').text(details.name);
        $('#level-explanation').text(details.explanation);
    }

    // Start the quiz level based on level type
    function startLevel() {
        switch (parseInt(levelId)) {
            case 2:
                startDevineFilmGame();
                break;
            case 3:
            case 7:
                startMatchingGame();
                break;
            case 5:
                startWordleGame();
                break;
            default:
                displayQuestion();
                break;
        }
    }

    // Display the current question
    function displayQuestion() {
        if (currentQuestionIndex < questions.length) {
            let question = questions[currentQuestionIndex];
            $('#question').text(question.question);
            let optionsHtml = question.options.map(function(option, index) {
                return `<li id="option-${index}" class="option" data-isCorrect="${option.isCorrect}">${option.text}</li>`;
            }).join('');
            $('#options').html(optionsHtml);
            setupOptionListeners();
            startTimer();
        } else {
            endLevel();
        }
    }

    // Set up listeners for question options
    function setupOptionListeners() {
        $('#options li').on('click', function() {
            let selectedOption = $(this);
            handleOptionSelection(selectedOption);
        });
    }

    // Handle option selection with visual feedback and score calculation
    function handleOptionSelection(selectedOption) {
        let isCorrect = $(selectedOption).data('isCorrect');
        $('#options li').removeClass('correct incorrect unselected no-hover').off('click');
        
        let elapsedTime = Date.now() - startTime; 
        let points = isCorrect && !timerExpired ? calculatePoints(elapsedTime) : 10;
        if (isCorrect) {
            score += points;
            $(selectedOption).addClass('correct');
            $('#options li').not(selectedOption).addClass('unselected');
            $('#qst-' + (currentQuestionIndex + 1)).addClass('right');
        } else {
            $(selectedOption).addClass('incorrect');
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
            if (currentQuestionIndex < questions.length - 1) {
                displayQuestion(); // Progress to the next question
            } else {
                endLevel(); // End the level if it was the last question
            }
        }, 2500);
    }

    // Start a timer for the current question
    function startTimer() {
        startTime = Date.now(); // Reset the start time for each new question
        timerExpired = false;
        timer = setTimeout(function() {
            timerExpired = true;
        }, 12000); // 12 seconds until the timer expires
    }

    // Calculate points based on correctness and time elapsed
    function calculatePoints(elapsedTime) {
        let timeFactor = Math.max(0, 12000 - elapsedTime) / 12000; // Decrease points over time
        return isCorrect ? Math.round(10 * timeFactor) : 0;
    }

    // End the level and send the score to the server
    function endLevel() {
        $.ajax({
            url: '/quiz/update-progress',
            type: 'POST',
            data: { level: levelId, score: score },
            success: function(response) {
                alert('Level completed! ' + response.message);
                window.location.href = '/next-level'; // Redirect to the next level
            },
            error: function(error) {
                console.error('Error sending score:', error);
            }
        });
    }

    // Shuffle array utility function
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]]; // Swap elements
        }
        return array;
    }
});