@extends('layouts.app')

@section('content')
<div class='question-wrapper'>
    <div class='question-container'>
        <div class='level-info'>
            <h1 id='level-name'>{{ $level->name }}</h1>
            <p id='level-explanation'>{{ $level->explanation }}</p>
            <button id='startLevel' class='default'>C'est parti !</button>
        </div>
        <div class='level-content' style="display:none;">
            <p id='level-title'>{{ $level->name }}</p>
            <div class='question-header'>
                <div class='kernels'>
                    @for ($i = 1; $i <= 8; $i++)
                        <svg id='qst-{{ $i }}' class='kernel'>
                            <path d='M28.5319 19.8497C26.6984 22.0195 23.948 22.1162 22.9043 22.0658C22.6585 22.0538 22.4308 22.2007 22.3381 22.4282C22.2192 22.72 22.0782 23.0803 21.9291 23.497C21.5563 24.5276 21.5402 24.9201 21.3689 25.2421C20.5327 26.794 18.9147 27.8145 17.0671 27.9897C14.3772 28.2352 12.2897 26.8947 11.2601 24.2015C11.25 24.1773 11.2419 24.1512 11.2379 24.127C11.113 23.6459 10.9881 23.1628 10.8631 22.6798C10.7705 22.3195 10.3695 22.1423 10.037 22.3034C9.19076 22.718 7.75816 23.2172 6.03943 22.9696C4.42952 22.7341 3.33945 21.9612 2.89214 21.627C0.530656 19.8497 -0.39016 17.4423 0.149837 14.5579C0.296926 13.7668 0.603193 12.2029 1.85445 11.0374C2.26348 10.661 2.46296 10.6087 5.21131 9.13124C5.68078 8.88165 6.08779 8.66024 6.41421 8.48109C6.62577 8.36636 6.74667 8.13488 6.71242 7.89535C6.251 4.65063 7.5486 1.70381 9.78718 0.574601C10.8349 0.0411947 12.7753 -0.292939 14.3308 0.361238C14.5041 0.435714 14.5786 0.524278 16.517 2.11443C16.5573 2.14865 17.2262 2.69615 17.5849 2.99003C17.7239 3.10073 17.9053 3.14703 18.0786 3.10878C18.4513 3.02626 18.943 2.91958 19.5132 2.79478C21.8061 2.28351 21.9008 2.20904 22.2635 2.24124C23.41 2.33786 24.5162 2.85516 25.5035 3.76095C26.3599 4.54998 26.914 5.44369 27.1638 6.41188C27.327 7.0419 27.186 7.92152 26.9643 9.66465C26.9079 10.1035 26.8495 10.4919 26.8031 10.81C26.7669 11.0455 26.8757 11.279 27.0832 11.3997C27.8408 11.8385 29.5616 13.0684 29.9323 15.3067C30.3313 17.7241 28.8503 19.4793 28.5319 19.8537V19.8497Z' />
                        </svg>
                    @endfor
                </div>
                <div class='counter'>
                    <p></p>
                </div>
            </div>
            <div class='questions'>
                <h3 id='question'></h3>
                <ul id='options'></ul>
                <p id='score-display'></p>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    let currentQuestionIndex = 0;
    let questions = @json($level->questions);
    let score = 0; // Initialize score variable globally
    let startTime, endTime; // Variables to calculate elapsed time

    $('#startLevel').click(function() {
        $('.level-info').hide();
        $('.level-content').show();
        startTime = new Date(); // Start timer when the level starts
        displayQuestion(questions[currentQuestionIndex]);
    });

    function displayQuestion(question) {
        endTime = new Date(); // End time for the previous question
        if (currentQuestionIndex > 0) {
            let elapsedTime = endTime - startTime;
            score += calculatePoints(elapsedTime); // Calculate points and add to score
        }
        startTime = new Date(); // Reset start time for the new question
        
        $('#question').text(question.question);
        let optionsHtml = question.choices.map(choice => `<li>${choice.choice_text}</li>`).join('');
        $('#options').html(optionsHtml);
        $('#options li').on('click', function() {
            let choiceIndex = $('#options li').index(this);
            validateAnswer(question.id, choiceIndex, question.correct_answer);
        });
        updateQuestionCounter(currentQuestionIndex + 1, questions.length);
    }

    function validateAnswer(questionId, choiceIndex, correctAnswer) {
        let selectedOption = questions[currentQuestionIndex].choices[choiceIndex].choice_text;
        fetch(`/levels/{{ $level->id }}/questions/${questionId}/verify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ selectedOption })
        })
        .then(response => response.json())
        .then(data => {
            processResponse(data.correct, choiceIndex, correctAnswer);
        });
    }

    function processResponse(isCorrect, choiceIndex, correctAnswer) {
        $('#options li').each(function() {
            $(this).removeClass('correct incorrect unselected')
                .addClass($(this).text() === correctAnswer ? 'correct' : 'unselected');
        });

        let selectedLi = $('#options li').eq(choiceIndex);
        selectedLi.removeClass('unselected').addClass(isCorrect ? 'correct' : 'incorrect');

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


    function updateQuestionCounter(current, total) {
        $('.counter p').text(current + '/' + total);
    }

    function calculatePoints(elapsedTime) {
        return Math.max(10, 50 - Math.floor(elapsedTime / 1000 / 12 * 40));
    }

    function endLevel() {
        endTime = new Date();
        let elapsedTime = endTime - startTime;
        score += calculatePoints(elapsedTime); // Add points for the last question

        var levelId = {{ $level->id }}; // Ensure levelId is correctly set
        var nextLevel = levelId + 1; // Increment level id for next level URL
        var nextLevelUrl = `/levels/${nextLevel}`;

        fetch(`/level/${levelId}/score`, { // Correct URL formation using levelId
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is correct
            },
            body: JSON.stringify({ score: score }) // Ensure the payload is correct
        })
        .then(response => response.json())
        .then(data => {
            $('.question-container').html(`
                <h3>Félicitations, tu as terminé ce niveau avec un score de ${score} points!</h3>
                <button class="default"><a href="${nextLevelUrl}">Passer au niveau ${nextLevel}</a></button>`);
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>

@endsection
