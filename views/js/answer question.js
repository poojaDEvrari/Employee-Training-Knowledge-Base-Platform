/**
 * Created by Bhanuka on 4/7/2018.
 */
//var inputs, index;
var mcq = [];
var tf = [];
var short = [];
var answers = [];
count = 0;
var Noanswer = false;

function show_alert(message) {
    if (confirm(message)) {
        console.log(answers);
        var TraineeID = '<%= Session["trainee"]%>';
        console.log(QuizID);
        var sendData = function () {
            $.post('../controllers/answer creation.php?QuizID=' + QuizID, {
                data: answers
            }, function (response) {
                window.location = "view enrolled.php?attempt=success";
            });
        }
        sendData();
    } else
        return false;
}

$('[name=submit]').on('click', function (e) {
    answers = [];
    Noanswer = false;
    $("[qType=mcq]").each(function () {
        const questionId = $(this).attr('name');
        if (!$(`[name=${questionId}]`).is(':checked')) {
            Noanswer = true;
            $(this).parent().parent().css({"background-color": "#ffd1cb"});
            count = count + 1;
            if (count > 3) {
                mcq.push(questionId);
                mcq.push("");
                count = 0;
                answers.push(mcq);
                mcq = [];
            }
        }
        else {
            $(this).parent().parent().css({"background-color": "#ffffff"});
            count = count + 1;
            if (count > 3) {
                mcq.push(questionId);
                mcq.push($(`[name=${questionId}]:checked`).val());
                count = 0;
                answers.push(mcq);
                mcq = [];
            }

        }

    })

    $("[qType=tf]").each(function () {
        const questionId = $(this).attr('name');
        if (!$(`[name=${questionId}]`).is(':checked')) {
            Noanswer = true;
            $(this).parent().parent().css({"background-color": "#ffd1cb"});
            count = count + 1;
            if (count > 1) {
                tf.push(questionId);
                tf.push("");
                count = 0;
                answers.push(tf);
                tf = [];
            }
        }
        else {
            $(this).parent().parent().css({"background-color": "#ffffff"});
            count = count + 1;
            if (count > 1) {
                tf.push(questionId);
                tf.push($(`[name=${questionId}]:checked`).val());
                count = 0;
                answers.push(tf);
                tf = [];
            }

        }

    })

    $("[qType=short]").each(function () {
        const questionId = $(this).attr('name');
        //console.log(questionId);
        if ($(`[name=${questionId}]`).val() == "") {
            Noanswer = true;
            //console.log(2);
            $(this).parent().css({"background-color": "#ffd1cb"});
            $(this).css({"background-color": "#ffd1cb"});
            short.push(questionId);
            short.push("");
            answers.push(short);
            short = [];
        }
        else {
            $(this).parent().css({"background-color": "#ffffff"});
            $(this).css({"background-color": "#ffffff"});
            short.push(questionId);
            short.push($(`[name=${questionId}]`).val());
            answers.push(short);
            short = [];
        }
    })

    if (Noanswer) {
        show_alert("There are some unanswered questions! Are you sure you want to submit?");
    }
    else {
        show_alert("Are you sure you want to submit?");
    }

});