@extends('layouts.app')

@section('body-class', 'levels')

@section('content')
<div class='question-wrapper'>
    <div class='question-container'>
        <div class='level-info'>
        <h1 id='level-name'>{{ $level->translated_name }}</h1>
        <p id='level-explanation'>{{ $level->translated_explanation }}</p>
            <button id='startLevel' class='default'>{{ __('messages.C\'est parti !') }}</button>
            <div class="navigation-options" id="nav-quiz">
                <a href="{{ app()->getLocale() == 'en' ? '/en/levels' : '/levels' }}" class="map-link">
                    <i class="fas fa-home"></i>
                </a>
            </div>
        </div>
        <div class='level-content' style="display:none;">
            <p id='level-title'>{{ $level->translated_name }}</p>
            <div class='question-header'>
                <div class='kernels'>
                    @for ($i = 1; $i <= 8; $i++)
                        <svg id='qst-{{ $i }}' class='kernel' viewBox='0 0 30 30'>
                            <path d='M28.5319 19.8497C26.6984 22.0195 23.948 22.1162 22.9043 22.0658C22.6585 22.0538 22.4308 22.2007 22.3381 22.4282C22.2192 22.72 22.0782 23.0803 21.9291 23.497C21.5563 24.5276 21.5402 24.9201 21.3689 25.2421C20.5327 26.794 18.9147 27.8145 17.0671 27.9897C14.3772 28.2352 12.2897 26.8947 11.2601 24.2015C11.25 24.1773 11.2419 24.1512 11.2379 24.127C11.113 23.6459 10.9881 23.1628 10.8631 22.6798C10.7705 22.3195 10.3695 22.1423 10.037 22.3034C9.19076 22.718 7.75816 23.2172 6.03943 22.9696C4.42952 22.7341 3.33945 21.9612 2.89214 21.627C0.530656 19.8497 -0.39016 17.4423 0.149837 14.5579C0.296926 13.7668 0.603193 12.2029 1.85445 11.0374C2.26348 10.661 2.46296 10.6087 5.21131 9.13124C5.68078 8.88165 6.08779 8.66024 6.41421 8.48109C6.62577 8.36636 6.74667 8.13488 6.71242 7.89535C6.251 4.65063 7.5486 1.70381 9.78718 0.574601C10.8349 0.0411947 12.7753 -0.292939 14.3308 0.361238C14.5041 0.435714 14.5786 0.524278 16.517 2.11443C16.5573 2.14865 17.2262 2.69615 17.5849 2.99003C17.7239 3.10073 17.9053 3.14703 18.0786 3.10878C18.4513 3.02626 18.943 2.91958 19.5132 2.79478C21.8061 2.28351 21.9008 2.20904 22.2635 2.24124C23.41 2.33786 24.5162 2.85516 25.5035 3.76095C26.3599 4.54998 26.914 5.44369 27.1638 6.41188C27.327 7.0419 27.186 7.92152 26.9643 9.66465C26.9079 10.1035 26.8495 10.4919 26.8031 10.81C26.7669 11.0455 26.8757 11.279 27.0832 11.3997C27.8408 11.8385 29.5616 13.0684 29.9323 15.3067C30.3313 17.7241 28.8503 19.4793 28.5319 19.8537V19.8497Z' />
                        </svg>
                    @endfor
                </div>
                <div class='counter'>
                    <p></p>
                </div>
            </div>
            <div class='questions'>
                @if ($level->id == 2)
                    <div id='emojis'>
                        <div id='emojisQuestion'></div>
                        <div id='container'>
                            <div class="input-wrapper">
                                <input type='text' id='movie-input' placeholder='Tape un titre...' autocomplete='off' />
                                <div id='suggestions' class="suggestions-list"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <h3 id='question'></h3>
                    <ul id='options'>
                    </ul>
                    <p id='score-display'></p>
                @endif
            </div>
            <div class="navigation-options">
                <a href="{{ app()->getLocale() == 'en' ? '/en/levels' : '/levels' }}" class="map-link">
                    <i class="fas fa-home"></i>
                </a>
                <a href="#" class="restart-link" onclick="window.location.reload();">
                    <i class="fas fa-redo-alt"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
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
        let questions = @json($level->questions); // Questions are directly fetched from the $level object

        $('#startLevel').click(function() {
            console.log("Start button clicked");
            $('.level-info').hide();
            $('.level-content').show();
            startTime = new Date();

            if ({{ $level->id }} == 2) {
                console.log("Loading emoji questions for level 2");
                loadEmojiQuestions();
            } else {
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
            $('#question').text(question.text);
            let optionsHtml = question.choices.map(choice => `<li style="${choice.choice_text.trim() === '' ? 'display: none;' : ''}">${choice.choice_text}</li>`).join('');

            $('#options').html(optionsHtml);
            $('#options li').on('click', function() {
            if ($(this).css('display') !== 'none') {
            let choiceIndex = $('#options li').index(this);
            let selectedText = $(this).text();
        
        validateAnswer(question.id, choiceIndex, question.correct_answer);

        $.ajax({
            url: `/levels/{{ $level->id }}/questions/${question.id}/verify`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                selectedOption: selectedText
            },
            success: function(response) {
                $('#options li').each(function() {
                    let liText = $(this).text();

                    if (liText === response.correctAnswerFr || liText === response.correctAnswerEn) {
                        $(this).addClass('correct');
                    } else {
                        $(this).removeClass('correct');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la vérification de la réponse:', error);
            }
        });
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
            if ($(this).hasClass('correct')) {
            $(this).removeClass('incorrect unselected');
            } else {
                $(this).removeClass('incorrect unselected')
                }
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
            }, 2000);
        }

        function processEmojiResponse(isCorrect) {
            if (isCorrect) {
                $('#movie-input').removeClass('incorrect').addClass('correct');
                $('#qst-' + (currentQuestionIndex + 1)).addClass('right');
                
                score += calculatePoints(new Date() - startTime);
            } else {
                $('#movie-input').removeClass('correct').addClass('incorrect');
                $('#qst-' + (currentQuestionIndex + 1)).addClass('wrong');
                
                score += 0; 
            }

            setTimeout(function() {
                $('#movie-input').val('').removeClass('correct incorrect');
                $('#suggestions').empty().hide();
                currentQuestionIndex++;
                if (currentQuestionIndex < questions.length) {
                    displayQuestion(questions[currentQuestionIndex]);
                } else {
                    endLevel();
                }
            }, 2000);
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
                $('#suggestions').empty().hide();
                return;
            }

            $('#suggestions').show(); 

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
                            
                            var movieId = movie.id;
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

                        $('#suggestions').append(movieSuggestion);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching movie suggestions:', error);
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
                    <p id='level-title'>{{ $level->translated_name }}</p>
                    <h3>${message}</h3>
                    <div class="navigation-options">
                        @if ($level->id != 1)
                            <a href="${previousLevelUrl}" class="previous-link">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        @endif

                        <a href="{{ app()->getLocale() == 'en' ? '/en/levels' : '/levels' }}" class="map-link">
                            <i class="fas fa-home"></i>
                        </a>

                        <a href="#" class="retry-link" onclick="window.location.reload();">
                            <i class="fas fa-redo-alt"></i>
                        </a>

                        @if ($level->id != 8)
                            <a href="${nextLevelUrl}" class="next-link">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                `);
            })
            .catch(error => console.error('Error sending score:', error));
        }
    });
</script>

@endsection
