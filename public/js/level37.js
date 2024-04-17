$(document).ready(function() {
    var pairContainerLeft = $('#pair-container-left');
    var pairContainerRight = $('#pair-container-right');
    var selectedPairs = [];

    var urlParams = new URLSearchParams(window.location.search);
    var level = urlParams.get('level') || '1';

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]]; 
        }
    }

    function fetchPairs(level) {
        $.ajax({
            url: '../php/get_pairs.php',
            type: 'GET',
            data: { level: level },
            dataType: 'json',
            success: function(pairs) {
                displayPairs(pairs);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function displayPairs(pairs) {
        let leftColumnPairs = [];
        let rightColumnPairs = [];

        pairs.forEach(function(pair, index) {
            if (index % 2 === 0) {
                leftColumnPairs.push(pair);
            } else {
                rightColumnPairs.push(pair);
            }
        });

        shuffleArray(leftColumnPairs);
        shuffleArray(rightColumnPairs);

        appendPairsToContainer(pairContainerLeft, leftColumnPairs);
        appendPairsToContainer(pairContainerRight, rightColumnPairs);
    }

    function appendPairsToContainer(container, pairs) {
        pairs.forEach(function(pair) {
            var pairElement = $('<div class="pair"></div>').text(pair.name).data('pairId', pair.pair_id);
            container.append(pairElement);

            pairElement.click(function() {
                $(this).toggleClass('selected');
                var pairId = $(this).data('pairId');
                var index = selectedPairs.findIndex(sp => sp.pairId === pairId);
                if (index > -1) {
                    selectedPairs.splice(index, 1);
                } else {
                    selectedPairs.push({ pairId: pairId, name: pair.name });
                }
            });
        });
    }

    function checkPairs() {
        $.ajax({
            url: '../php/check_pairs.php',
            type: 'POST',
            data: { pairs: JSON.stringify(selectedPairs) },
            dataType: 'json',
            success: function(response) {
                response.forEach(function(pairResult) {
                    var pairElement = $('.pair').filter(function() {
                        return $(this).text() === pairResult.name;
                    });
                    if(pairResult.isCorrect) {
                        pairElement.addClass('correct');
                    } else {
                        pairElement.addClass('incorrect');
                    }
                });
            },            
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    $('#check-pairs').click(checkPairs);

    fetchPairs(level);
});
