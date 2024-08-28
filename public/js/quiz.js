$(document).ready(function() {
    console.log("Document ready");
    let pseudo = document.cookie.match(new RegExp('(^| )pseudo=([^;]+)'));
    if (!pseudo) {
        pseudo = prompt('Entrez votre pseudo:');
        if (pseudo) {
            document.cookie = `pseudo=${pseudo}; path=/; max-age=31536000`; // 1 year
        } else {
            alert('Pseudo non trouvé. Retour à l\'accueil.');
            window.location.href = '/';
            return;
        }
    } else {
        pseudo = pseudo[2];
    }

    let currentQuestionIndex = 0;
    let score = 0;
    let startTime, endTime;
    let questions = [];

    $('#startLevel').click(function() {
        console.log("Start button clicked");
        $('.level-info').hide();
        $('.level-content').show();
        startTime = new Date();

        if ({{ $level->id }} == 2) {
            console.log("Loading emoji questions for level 2");
            loadEmojiQuestions();
        } else {
            console.log("Loading standard questions");
            questions = @json($level->questions);
            if (questions.length > 0) {
                displayQuestion(questions[currentQuestionIndex]);
            } else {
                console.error("No questions available for this level.");
            }
        }
    });

    function displayQuestion(question) {
        console.log("Displaying question:", question);
        endTime = new Date();
        if (currentQuestionIndex > 0) {
            let elapsedTime = endTime - startTime;
            score += calculatePoints(elapsedTime);
        }
        startTime = new Date();

        if ({{ $level->id }} == 2) {
            displayEmojiQuestion(question);
        } else {
            displayStandardQuestion(question);
        }
    }

    function displayStandardQuestion(question) {
        $('#question').text(question.question);
        let optionsHtml = question.choices.map(choice => `<li style="${choice.choice_text.trim() === '' ? 'display: none;' : ''}">${choice.choice_text}</li>`).join('');

        $('#options').html(optionsHtml);
        $('#options li').on('click', function() {
            if($(this).css('display') !== 'none') {
                let choiceIndex = $('#options li').index(this);
                validateAnswer(question.id, choiceIndex, question.correct_answer);
            }
        });
        updateQuestionCounter(currentQuestionIndex + 1, questions.length);
    }

    function validateAnswer(questionId, choiceIndex, correctAnswer) {
    let selectedOption = questions[currentQuestionIndex].choices[choiceIndex].choice_text;
    console.log("Validating answer:", selectedOption);

    fetch(`/levels/{{ $level->id }}/questions/${questionId}/verify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ selectedOption })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log("Response from server:", data);
        if (data && typeof data.correct !== 'undefined') {
            processResponse(data.correct, choiceIndex, correctAnswer);
        } else {
            throw new Error('Invalid data format received from server.');
        }
    })
    .catch(error => {
        console.error('Error validating answer:', error);
        alert('There was an error processing your request. Please try again.');
    });
}

    function displayEmojiQuestion(question) {
        $('#emojisQuestion').text(question.question);
        correctAnswerId = question.answer_id;

        $('#movie-input').val('').css('border', '');
        $('.kernel').removeClass('current');
        $('#qst-' + (currentQuestionIndex + 1)).addClass('current');

        updateQuestionCounter(currentQuestionIndex + 1, questions.length);
    }

    function processResponse(isCorrect, choiceIndex, correctAnswer) {
        if ({{ $level->id }} == 2) {
            processEmojiResponse(isCorrect);
        } else {
            processStandardResponse(isCorrect, choiceIndex, correctAnswer);
        }
    }

    function processStandardResponse(isCorrect, choiceIndex, correctAnswer) {
        console.log("Processing standard response. Is correct?", isCorrect);

        $('#options li').each(function() {
            $(this).removeClass('correct incorrect unselected')
                .addClass($(this).text() === correctAnswer ? 'correct' : 'unselected');
        });

        let selectedLi = $('#options li').eq(choiceIndex);
        selectedLi.removeClass('unselected').addClass(isCorrect ? 'correct' : 'incorrect');

        if (isCorrect) {
            score += calculatePoints(new Date() - startTime);
        } else {
            score += 0;
        }

        $('#qst-' + (currentQuestionIndex + 1)).addClass(isCorrect ? 'right' : 'wrong');

        setTimeout(() => {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                displayQuestion(questions[currentQuestionIndex]);
            } else {
                endLevel();
            }
        }, 2500);
    }

    function processEmojiResponse(isCorrect) {
        if (isCorrect) {
            $('#movie-input').css('border', '2px solid green');
            $('#qst-' + (currentQuestionIndex + 1)).addClass('right');
            
            score += calculatePoints(new Date() - startTime);
        } else {
            $('#movie-input').css('border', '2px solid red');
            $('#qst-' + (currentQuestionIndex + 1)).addClass('wrong');
            
            score += 0; 
        }

        setTimeout(function() {
            $('#movie-input').css('border', '');
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                displayQuestion(questions[currentQuestionIndex]);
            } else {
                endLevel();
            }
        }, 2500);
    }

    function loadEmojiQuestions() {
        $.ajax({
            url: '{{ route("emoji.data") }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("Emoji questions loaded:", data);
                if (!data || !$.isArray(data)) {
                    throw new Error('Data is not an array');
                }
                questions = data;
                if (questions.length > 0) {
                    displayQuestion(questions[currentQuestionIndex]);
                } else {
                    console.error("No emoji questions available.");
                }
            },
            error: function(xhr, status, error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        });
    }

    $('#movie-input').on('input', function() {
        var userInput = $(this).val();
        if(userInput.length < 3) {
            $('#suggestions').empty();
            return;
        }
        $.ajax({
            url: '{{ route("tmdb.api") }}',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ query: userInput }),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#suggestions').empty();
                $.each(data, function(i, movie) {
                    var posterUrl = movie.poster_path ? `https://image.tmdb.org/t/p/w92${movie.poster_path}` : '/assets/images/default.png';
                    var movieSuggestion = $('<div>').addClass('movie-suggestion-item');
                    movieSuggestion.append($('<img>').attr('src', posterUrl).attr('alt', 'Poster').addClass('movie-suggestion-poster'));
                    movieSuggestion.append($('<span>').text(movie.title).addClass('movie-suggestion-title'));

                    movieSuggestion.on('click', function() {
                        $('#movie-input').val(movie.title);
                        $('#movie-input').data('movieId', movie.id);
                        $('#suggestions').empty();
                    });

                    $('#suggestions').append(movieSuggestion);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching movie suggestions:', error);
            }
        });
    });

    $('#submitAnswer').on('click', function() {
        var movieId = $('#movie-input').data('movieId');
        if (!movieId) {
            alert('Choisis un film !');
            return;
        }
        $.ajax({
            url: '{{ route("level2.check") }}',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ movieId: movieId }),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                processEmojiResponse(data.correct);
            },
            error: function(xhr, status, error) {
                console.error('Error submitting emoji answer:', error);
            }
        });
    });

    function updateQuestionCounter(current, total) {
        $('.counter p').text(current + '/' + total);
    }

    function calculatePoints(elapsedTime) {
        return Math.max(10, 50 - Math.floor(elapsedTime / 1000 / 12 * 40));
    }

    function endLevel() {
        console.log("End of level reached");
        endTime = new Date();
        let elapsedTime = endTime - startTime;
        score += calculatePoints(elapsedTime);

        var levelId = {{ $level->id }};
        var nextLevel = levelId + 1;
        var previousLevel = levelId - 1;
        var nextLevelUrl = `/levels/${nextLevel}`;
        var previousLevelUrl = `/levels/${previousLevel}`;

        console.log("Sending score:", score);

        fetch(`/scores/${levelId}`, { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ score: score })
        })
        .then(response => response.json())
        .then(data => {
            let message;
            if (data.message === 'Score amélioré et mis à jour avec succès') {
                message = `Tu t'es surpassé.e ! Ton nouveau score est de ${score} points.`;
            } else if (data.message === 'Ancien score conservé, score actuel inférieur') {
                message = `Ton score est de ${score} points, mais ton ancien score était meilleur et a été conservé.`;
            } else {
                message = `Bravo, tu as terminé ce niveau avec un score de ${score} points !`;
            }
            
            $('.question-container').html(`
                <h3>${message}</h3>
                <button class="default"><a href="${nextLevelUrl}">Passer au niveau ${nextLevel}</a></button>
                <div class="navigation-options">
                    <a href="${previousLevelUrl}" class="previous-link">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    
                    <a href="{{ app()->getLocale() == 'en' ? '/en/levels' : '/levels' }}" class="map-link">
                        <i class="fas fa-home"></i>
                    </a>
                    
                    <a href="#" class="retry-link" onclick="window.location.reload();">
                        <i class="fas fa-redo-alt"></i>
                    </a>
                </div>
            `);
        })
        .catch(error => console.error('Error sending score:', error));
    }

});