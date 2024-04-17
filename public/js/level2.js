$(document).ready(function() {
    var movieInput = $('#movie-input');
    var suggestionsList = $('#suggestions');
    var submitButton = $('#submitAnswer');
    var score = 0;
    var currentQuestionIndex = 0;
    var questions = [];
    var correctAnswerId = null;

    function updateQuestionCounter(current, total) {
        $('.counter p').text(current + '/' + total);
    }

    function updateScore(isCorrect) {
        score += isCorrect ? 10 : 0; 
        updateQuestionCounter(currentQuestionIndex + 1, questions.length);
    }

    function loadQuestions() {
        $.ajax({
            url: '../php/get_emoji_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data || !$.isArray(data)) {
                    throw new Error('Data is not an array');
                }
                questions = data;
                displayQuestion(currentQuestionIndex);
            },
            error: function(xhr, status, error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        });
    }

    function displayQuestion(index) {
        if (index >= questions.length) {
            endLevel();
            return;
        }
    
        var question = questions[index];
        $('#emojisQuestion').text(question.question);
        correctAnswerId = question.answer_id;
    
        $('#movie-input').val('').css('border', '');
    
        $('.kernel').removeClass('current');
        $('#qst-' + (index + 1)).addClass('current');
    
        updateQuestionCounter(index + 1, questions.length);
    }    

    movieInput.on('input', function() {
        var userInput = $(this).val();
        if(userInput.length < 3) {
            suggestionsList.empty();
            return;
        }
        $.ajax({
            url: '../php/tmdb_api.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ query: userInput }),
            success: function(data) {
                suggestionsList.empty();
                $.each(data, function(i, movie) {
                    var posterUrl = movie.poster_path ? `https://image.tmdb.org/t/p/w92${movie.poster_path}` : '../assets/images/default.png';
                    var movieSuggestion = $('<div>').addClass('movie-suggestion-item');
                    movieSuggestion.append($('<img>').attr('src', posterUrl).attr('alt', 'Poster').addClass('movie-suggestion-poster'));
                    movieSuggestion.append($('<span>').text(movie.title).addClass('movie-suggestion-title'));

                    movieSuggestion.on('click', function() {
                        movieInput.val(movie.title);
                        movieInput.data('movieId', movie.id);
                        suggestionsList.empty();
                    });

                    suggestionsList.append(movieSuggestion);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    submitButton.on('click', function() {
        var movieId = movieInput.data('movieId');
        if (!movieId) {
            alert('Choisis un film !');
            return;
        }
        $.ajax({
            url: '../php/check_emoji_answer.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ movieId: movieId }),
            success: function(data) {
                if (data.correct) {
                    movieInput.css('border', '2px solid green');
                    $('#qst-' + (currentQuestionIndex + 1)).addClass('right');
                } else {
                    movieInput.css('border', '2px solid red');
                    $('#qst-' + (currentQuestionIndex + 1)).addClass('wrong');
                    
                    movieInput.val(data.correctTitle);
                }
    
                setTimeout(function() {
                    movieInput.css('border', '');
                    currentQuestionIndex++;
                    if (currentQuestionIndex < questions.length) {
                        displayQuestion(currentQuestionIndex);
                    } else {
                        endLevel();
                    }
                }, 2500);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });    

    loadQuestions();

    function endLevel() {
        updateScore();
        var nextLevel = parseInt(currentQuestionIndex) + 1;
        $('.question-container').html(`<h3>Félicitations, tu as terminé ce niveau avec un score de ${score} points!</h3>` +
            `<button class="default"><a href="/quiz.php?level=${nextLevel}">Passer à la salle ${nextLevel}</a></button>`);
    }
});
