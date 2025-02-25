/**
 * Created by Bhanuka on 2/1/2018.
 */

$('[name=next]').on('click', function (e) {
    e.preventDefault();
    $("#questionForm")[0].reportValidity();
    if ($("#questionForm")[0].checkValidity()) {
        nextClick();
        $('[name=question]').val("");
        $('[name=choice]').val("");
        $('[name=shortanswer]').val("");
        $('[name=marks]').val("");
    }
});

$('[name=submit]').on('click', function (e) {
    e.preventDefault();
    $("#questionForm")[0].reportValidity();
    if ($("#questionForm")[0].checkValidity()) {
        nextClick();
        $('[name=question]').val("");
        $('[name=choice]').val("");
        $('[name=shortanswer]').val("");
        $('[name=marks]').val("");

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        var QuizID = parseInt(getParameterByName('QuizID'));
        $.post('../controllers/question creation.php?QuizID=' + QuizID, {
            data: questions
        }, function (response) {
            window.location = "add quiz.php?attempt=success";
        });
        questions = [];
        questionCount = 0;

    }
});


jQuery("#tf").hide();
jQuery("#short").hide();
jQuery("#mcq").hide();

//restart values
var currentValue = 0;
var questionCount = 0;
var questions = [];


function shortSelected(tf) {
    if (tf == true) {
        //shortQ form displayed
        jQuery("#short").show();
        //required attribute addition
        document.getElementById('short_answer').setAttribute('required', tf);
    } else {
        //shortQ form hidden
        document.getElementById('short_answer').removeAttribute('required');
        //required attribute removed
        jQuery("#short").hide();
    }
}

function mcqSelected(tf) {
    if (tf == true) {
        jQuery("#mcq").show();
        document.getElementById('choice').setAttribute('required', tf);
        document.getElementById('choice2').setAttribute('required', tf);
        document.getElementById('choice3').setAttribute('required', tf);
        document.getElementById('choice4').setAttribute('required', tf);
        document.getElementById('ansmcq').setAttribute('required', tf);
    } else {
        document.getElementById('choice').removeAttribute('required');
        document.getElementById('choice2').removeAttribute('required');
        document.getElementById('choice3').removeAttribute('required');
        document.getElementById('choice4').removeAttribute('required');
        document.getElementById('ansmcq').removeAttribute('required');
        jQuery("#mcq").hide();
    }
}

function tfSelected(tf) {
    if (tf == true) {
        jQuery("#tf").show();
        document.getElementById('tfRadio').setAttribute('required', tf);
    } else {
        document.getElementById('tfRadio').removeAttribute('required');
        jQuery("#tf").hide();
    }
}

function handleClick(myRadio) {
    if (myRadio == 'Short') {

        //jQuery("#short").show();
        //jQuery("#tf").hide();
        //jQuery("#mcq").hide();
        shortSelected(true);
        mcqSelected(false);
        tfSelected(false);
        currentValue = 1;
    } else if (myRadio == 'MCQ') {
        mcqSelected(true);
        shortSelected(false);
        tfSelected(false);
        currentValue = 2;
    } else if (myRadio == 'TF') {
        shortSelected(false);
        mcqSelected(false);
        tfSelected(true);
        currentValue = 3;
    }
}

function nextClick() {
    if (currentValue == 1) {

        questionCount = questionCount + 1;
        //initiate list
        var shortQ = [];

        //adding values
        shortQ.push('short');
        shortQ.push(questionCount);
        shortQ.push(document.getElementById('question').value);
        shortQ.push(document.getElementById('short_answer').value);
        shortQ.push(document.getElementById('marks').value);
        //console.log(shortQ);

        //pushing to main question list
        questions.push(shortQ);
        //console.log(questions);
    }
    if (currentValue == 2) {
        questionCount = questionCount + 1;
        var mcqQ = [];
        mcqQ.push('mcq');
        mcqQ.push(questionCount);
        mcqQ.push(document.getElementById('question').value);
        mcqQ.push(document.getElementById('choice').value);
        mcqQ.push(document.getElementById('choice2').value);
        mcqQ.push(document.getElementById('choice3').value);
        mcqQ.push(document.getElementById('choice4').value);
        mcqQ.push(document.getElementById('ansmcq').value);
        mcqQ.push(document.getElementById('marks').value);
        //console.log(mcqQ);
        questions.push(mcqQ);
        //console.log(questions);
    }
    if (currentValue == 3) {
        questionCount = questionCount + 1;
        var tfQ = [];
        tfQ.push('tf');
        tfQ.push(questionCount);
        tfQ.push(document.getElementById('question').value);
        if (document.getElementById('tfRadio').checked) {
            tfQ.push('True');
        } else {
            tfQ.push('False');
        }
        tfQ.push(document.getElementById('marks').value);
        //console.log(tfQ);
        questions.push(tfQ);


    }
    console.log(questions);
}