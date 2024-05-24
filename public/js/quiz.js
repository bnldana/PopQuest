$(document).ready(function() {
    const gameData = $('#gameData');
    let questions = JSON.parse(gameData.attr('data-questions'));
    const levelId = gameData.attr('data-level-id');
    const csrfToken = gameData.attr('data-csrf-token');
    const nextLevelUrl = gameData.attr('data-next-level-url');
    let currentQuestionIndex = 0;
    let score = 0;
    let startTime, endTime;

    $('#startLevel').click(function() {
        $('.level-info').hide();
        $('.level-content').show();
        startTime = new Date();
        displayQuestion(questions[currentQuestionIndex]);
    });

    function displayQuestion(question) {
        endTime = new Date();
        if (currentQuestionIndex > 0) {
            let elapsedTime = endTime - startTime;
            score += calculatePoints(elapsedTime);
        }
        startTime = new Date();
        
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
        fetch(`/levels/${levelId}/questions/${questionId}/verify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ selectedOption })
        })
        .then(response => response.json())
        .then(data => {
            processResponse(data.correct, choiceIndex, correctAnswer);
        });
    }

    function processResponse(isCorrect, choiceIndex, correctAnswer) {
        $('#options li').each(function(index) {
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
        }, 1500);
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
        score += calculatePoints(elapsedTime);

        fetch(`/level/${levelId}/score`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ score })
        })
        .then(response => response.json())
        .then(data => {
            $('.question-container').html(`
                <h3>Félicitations, tu as terminé ce niveau avec un score de ${score} points!</h3>
                <button class="default"><a href="${nextLevelUrl}">Passer au niveau suivant</a></button>`);
        })
        .catch(error => console.error('Error:', error));
    }
});
