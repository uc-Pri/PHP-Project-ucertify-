<?php
define("fileName", "PHP_PROJECT");
define("host_server", "localhost");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js">
    </script>
</head>
<style>
    #exp seq:before {
        content: attr(no);
    }
</style>
<body>
    <nav class="navbar border border-dark ">
        <a href="#" class="col-1 col-xs-4 navbar-brand"> <img
                src="https://www.ucertify.com/layout/themes/bootstrap4/images/logo/ucertify_logo.png"
                alt="uCertify Logo"></a>
        <h1 class=" col-xs-4 navbar-nav mx-auto">
            uCertify Prep Test</h1>
        </h1>
    </nav>
    <div class="box  float-left overflow-auto position-absolute w-25"
        style="height: calc(100vh - 72px); z-index: 1; display: none;">
        <div class="box-inner px-3 border bg-white border-dark ">
            <div class="mt-2 mb-2 btn-group">
                <button class="btn btn-outline-warning" id="unattempted_filter">Unattempted</button>
                <button class="btn btn-outline-primary" id="all_filter">All</button>
                <button class="btn btn-outline-success" id="attempted_filter">Attempted</button>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="badges  mt-2 d-flex justify-content-center"></div>
        <p id="question_items"></p>
        <form class="radio_options"></form>
        <div class="mt-2">
            <h3 class="text-dark heading"></h3>
            <small class="review text-wrap text-dark" id="exp"></small>
        </div>
        <!-- Modal  -->
        <div class="modal " id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Do you want to end the test?</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <p class="me-2 ">
                            <div>
                                <span>Total items</span>
                                <span class="d-flex justify-content-center text-primary" id="total_modal"></span>
                            </div>
                            </p>
                            <p class="me-2 ">
                            <div>
                                <span>Attempted</span>
                                <span class="d-flex justify-content-center text-success" id="attempt_modal">0</span>
                            </div>
                            </p>
                            <p class="me-2 ">
                            <div>
                                <span>Unattempted</span>
                                <span class="d-flex justify-content-center text-warning" id="unattempt_modal"></span>
                            </div>
                            </p>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary slide-toggle " data-bs-dismiss="modal">Go toitem list</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> 
                            <a href="/<?php echo fileName ?>/result.php" class="text-decoration-none text-white">End Test</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL -->
        <div class="modal" id="timeout">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Timeout!!!
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <a
                                href="/<?php echo fileName ?>/result.php" class="text-decoration-none text-white">End Test</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <footer class=" fixed-bottom mb-2 ">
            <div class=" d-flex justify-content-end ">
                <button class="btn" id="timer"></button>
                <button type="button" class="  btn btn-md-3 btn-outline-primary px-4 slide-toggle me-2">List</button>
                <button type="button" class=" btn btn-md-3 btn-outline-dark  px-3 me-2" id="prev">Previous</button>
                <button class="btn " id="page"></button>
                <button type="button" class=" btn btn-md-3 btn-outline-dark px-4 me-2" id="next">Next</button>
                <button type="button" class="end-test btn btn-md-3 btn-danger px-3 me-2" data-bs-toggle="modal"
                    data-bs-target="#myModal" onclick="">End Test
                </button>
            </div>
        </footer>
        <!-- JQUERY -->
        <script>
            $(document).ready(function () {
                // VARIABLES 
                var question_index = 1;
                var url = new URL(window.location.href);
                var no = url.searchParams.get("no");
                question_index = parseInt(no);
                if (no == 1) {
                    $("#prev").prop("disabled", true);
                }
                $.ajax(
                    {
                        url: ` http://<?php echo host_server ?>/<?php echo fileName ?>/file.json`,
                        type: "POST",
                        success: function (data) {
                            function getQues(question_index, data) {
                                // var val = question_index + 1;
                                var n = JSON.parse(data[question_index - 1]['content_text']);
                                $('#question_items').html(n['question']);
                                $('#question_items').prepend(`<b>Q${question_index}: </b>`);
                                $("#page").text(`0${question_index}`).append(` of ${data.length}`);
                                get_options(data);
                                storeValue(question_index, data);
                            }
                            function get_options(data) {
                                var n = JSON.parse(data[question_index - 1]['content_text']);
                                for (i = 0; i < n.answers.length; i++) {
                                    var ans_val = n.answers[i].answer;
                                    $('.radio_options').append(`<div class="d-flex">
                                                        <input id="${i}ans" type="radio" class="form-check-input radio_" name="radios" value="${i}">
                                                        <label class="form-check-label ms-1" for="${i}ans" id="option${i}">${ans_val}</label>
                                                    </div>`);
                                }
                            }
                            function storeValue(question_index, data) {
                                $(".form-check-input").click(function () {
                                    sessionStorage.setItem(`option${question_index - 1}`, $(this).attr("value"));
                                    $.post(
                                        "http://<?php echo host_server?>/<?php echo fileName?>/answer.php",
                                        {
                                            question: question_index - 1,
                                            answer: $(this).val(),
                                        },
                                        function (data) {
                                            sessionStorage.setItem(`result${question_index - 1}`, data);
                                            itemValue = sessionStorage.getItem(`result${question_index - 1}`);
                                        }
                                    );
                                });
                                itemValue = sessionStorage.getItem(`option${question_index - 1}`);
                                if (itemValue !== null) {
                                    $(`input[value="${itemValue}"]`).click();
                                }
                            }
                            getQues(question_index, data);
                            function newURL() {
                                var new_url = `/<?php echo fileName ?>/ques.php/?test=1&no=${question_index}`;
                                window.history.pushState("data ", "Title ", new_url);
                            }
                            function getItemNo() {
                                if (question_index > data.length) {
                                    question_index = data.length;
                                }
                                if (question_index < 10) {
                                    $("#page").text("0" + question_index).append(" of 11 ");
                                }
                                else {
                                    $("#page").text(question_index).append(" of 11 ");
                                }
                            }
                            function listSideBar() {
                                getItemNo();
                                for (list_index = 0; list_index < data.length; list_index++) {
                                    optValue = sessionStorage.getItem("option" + list_index);
                                    $('.box-inner').append(`<div class ="question_snippets">
                                        <a href="/<?php echo fileName ?>/ques.php/?test=1&no=${list_index + 1}" id=${"list" + list_index} class="snipps text-decoration-none text-dark " ><b> Ques ${list_index + 1} </b> ${data[list_index]['snippet']}</a>
                                        <br><span class="badge text-bg-warning mb-3 att${list_index}">Unattempted</span><br>
                                        </div>`);
                                    if (optValue !== null) {
                                        $(".att" + list_index).addClass("text-bg-success").text("attepmted").removeClass("text-bg-warning");
                                    }
                                    listbadges(list_index);
                                }
                            }
                            listSideBar();
                            listbadges(question_index);
                            function listbadges(question_index) {
                                $(".slide-toggle").click(function () {
                                    optValue = sessionStorage.getItem("option" + question_index);
                                    if (optValue !== null) {
                                        $(".att" + question_index)
                                        .addClass("text-bg-success")
                                        .text("attepmted")
                                        .removeClass("text-bg-warning");
                                    }
                                });
                            }
                            // NEXT BUTTON  
                            $('#next').click(function () {
                                $(".box").hide();
                                $(".radio_options").empty();
                                question_index++;
                                if (question_index <= data.length) {
                                    newURL();
                                    getQues(question_index, data);
                                    getItemNo();
                                    if (question_index == data.length) {
                                        $("#next").prop("disabled", true);
                                    }
                                    if (question_index > 0) {
                                        $("#prev").prop("disabled", false);
                                    }
                                }
                            });
                            // PREVIOUS BUTTON 
                            $('#prev').click(function () {
                                $(".box").hide();
                                $(".radio_options").empty();
                                question_index--;
                                if (question_index <= data.length) {
                                    newURL();
                                    getQues(question_index, data);
                                    getItemNo();
                                    if (question_index == 1) {
                                        $("#prev").prop("disabled", true);
                                    }
                                    if (question_index > 0) {
                                        $("#next").prop("disabled", false);
                                    }
                                }
                            });
                            // LIST BUTTON 
                            $(".slide-toggle").click(function () {
                                $(".box").toggle();
                            });
                            $("#total_modal").text(data.length);
                            // END BUTTON 
                            $(".end-test").click(function () {
                                var items = 0;
                                for (i = 0; i < data.length; i++) {
                                    attempt_data = sessionStorage.getItem("option" + i);
                                    if (attempt_data) {
                                        items = items + 1;
                                        $("#attempt_modal").text(items);
                                    }
                                }
                                $("#unattempt_modal").text(data.length - items);
                            });
                            // ALL FILTER 
                            $("#all_filter").click(function () {
                                $('.question_snippets').empty();
                                listSideBar();
                            });
                            // ATTEMPTED FILTER 
                            $("#attempted_filter").click(function () {
                                $('.question_snippets').empty();
                                for (list_index = 0; list_index < data.length; list_index++) {
                                    optValue = sessionStorage.getItem("option" + list_index);
                                    if (optValue !== null) {
                                        $('.box-inner').append(`<div class ="question_snippets">
                                        <a href="/<?php echo fileName ?>/ques.php/?test=1&no=${list_index + 1}" id=${"list" + list_index} class="snipps text-decoration-none text-dark " ><b> Ques ${list_index + 1} </b> ${data[list_index]['snippet']}</a>
                                        <br><span class="badge text-bg-success mb-3 att${list_index}">attempted</span><br>
                                        </div>`);
                                    }
                                }
                            });
                            // UNATTEMPTED FILTER 
                            $("#unattempted_filter").click(function () {
                                $('.question_snippets').empty();
                                for (list_index = 0; list_index < data.length; list_index++) {
                                    optValue = sessionStorage.getItem("option" + list_index);
                                    if (optValue == null) {
                                        $('.box-inner').append(`<div class ="question_snippets">
                                        <a href="/<?php echo fileName ?>/ques.php/?test=1&no=${list_index + 1}" id=${"list" + list_index} class="snipps text-decoration-none text-dark " ><b> Ques ${list_index + 1} </b> ${data[list_index]['snippet']}</a>
                                        <br><span class="badge text-bg-warning mb-3 att${list_index}">unattempted</span><br>
                                        </div>`);
                                    }
                                }
                            });
                            // TIMER WHEN TEST START DOES NOT RE-START AFTER RELOADING 
                            const parameter = new URL(location.href).searchParams;
                            const test = parameter.get('test');
                            if (test == 1) {
                                function startTimer() {
                                    // Set the timer to 30 minutes (in milliseconds)
                                    var timer = 30 * 60 * 1000;
                                    // Get the current time from session storage, if it exists
                                    var currentTime = sessionStorage.getItem('currentTime');
                                    if (currentTime) {
                                        timer = currentTime;
                                    }
                                    // Update the timer every 1000 milliseconds (1 second)
                                    var interval = setInterval(function () {
                                        timer -= 1000;
                                        // Update the current time in session storage
                                        sessionStorage.setItem('currentTime', timer);
                                        // Convert the timer value to minutes and seconds
                                        var minutes = Math.floor(timer / (60 * 1000));
                                        var seconds = Math.floor((timer % (60 * 1000)) / 1000);
                                        // Display the timer value on the page
                                        document.getElementById('timer').innerHTML = minutes + ':' + seconds;
                                        // If the timer has reached 0, clear the interval and reset the timer
                                        if (timer <= 0) {
                                            clearInterval(interval);
                                            sessionStorage.removeItem('currentTime');
                                            window.location = `/<?php echo fileName ?>/result.php`;
                                        }
                                    }, 1000);
                                }
                                // Start the timer when the page loads
                                window.onload = startTimer();
                            }
                            // REVIEW PAGE 
                            const params = new URL(location.href).searchParams;
                            const review = params.get('review');
                            if (review == 1) {
                                var index = 1;
                                // REVIEW PAGE URL 
                                function reviewPageUrl() {
                                    var new_url = `/<?php echo fileName ?>/ques.php/?review=1&no=${question_index}`;
                                    window.history.pushState("data ", "Title ", new_url);
                                }
                                function reviewPage(no, data) {
                                    $(".badges").empty();
                                    $(".form-check-input").attr("disabled", true);
                                    const id_num = (sessionStorage.getItem("option" + (no - 1)));
                                    $(`#option${id_num}`).addClass('text-danger');
                                    var answer_josn = JSON.parse(data[no - 1]["content_text"]).answers;
                                    for (var l = 0; l < answer_josn.length; l++) {
                                        if (an[l]['is_correct'] == 1) {
                                            $("#option" + l).removeClass('text-danger');
                                            $("#option" + l).addClass('text-success');
                                        }
                                    }
                                    $(".review").html(JSON.parse(data[no - 1]["content_text"]).explanation);
                                    $(".heading").text("Explanation");
                                    // APPEND BADGES ON REVIEW PAGE 
                                    if (sessionStorage.getItem("result" + (no - 1)) == 1) {
                                        $(".badges").append(
                                            '<div class="alert alert-success" role="alert">Correct</div>'
                                        )
                                    } else if (sessionStorage.getItem("result" + (no - 1)) == 0) {
                                        $(".badges").append(
                                            '<div class="alert alert-danger" role="alert">incorrect</div>'
                                        )
                                    } else {
                                        $(".badges").append(
                                            '<div class="alert alert-warning" role="alert">Unattempted</div>'
                                        )
                                    }
                                }
                                reviewPage(no, data);
                                $(".end-test").text("Go back").removeClass("btn-danger").addClass("btn-primary")
                                .removeAttr("data-bs-target").attr("onclick", `location.href='/<?php echo fileName?>/result.php'`);
                                // next button 
                                $("#next").click(function () {
                                    index++;
                                    reviewPageUrl();
                                    getItemNo();
                                    reviewPage(index, data);
                                })
                                // previous button 
                                $("#prev").click(function () {
                                    index--;
                                    reviewPageUrl();
                                    getItemNo();
                                    reviewPage(index, data);
                                })
                                for (li = 0; li < data.length; li++) {
                                    $(`#list${li}`).attr("href", `?review=1&no=${li + 1}`)
                                }
                            } 
                        }
                    }
                );
            });
        </script>
</body>