<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js">
    </script>
    <style>
        .circle {
            margin: 10px;
            width: 25px;
            height: 25px;
            border-radius: 31%;
            font-size: 17px;
            line-height: 23px;
            text-align: center;
            background: #808080;
            color: #fff;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        /* setting the text-align property to center*/
        td {
            padding: 5px;
            text-align: center;
        }
    </style>

</head>
<title>Document</title>
</head>

<body>
    <nav class="navbar  bg-outline-dark border border-dark ">
        <a href="#" class="col-1 col-xs-4 navbar-brand"> <img
                src="https://www.ucertify.com/layout/themes/bootstrap4/images/logo/ucertify_logo.png"
                alt="uCertify Logo"></a>
        <h1 class=" col-xs-4 navbar-nav mx-auto">
            Result</h1>
        </h1>
    </nav>
    <div class="mt-5 mb-5 ">
        <div class="d-flex justify-content-center">
            <button class="btn btn-outline- me-2   px-2 px-md-5">
                <div>
                    <span>
                        <i class="fa-solid fa-square-poll-vertical"></i></span>
                    <span class="d-inline-block result">
                        0%
                    </span>
                </div>
                <span class="d-none d-md-inline-block">
                    Result
                </span>

            </button>
            <button class="btn btn-outline- me-2 px-2 px-md-4">
                <div>
                    <span class=" text-primary "><i class="fa-solid fa-list"></i></span>
                    <span class="d-inline-block text-primary items"></span>
                </div>
                <span class="d-none d-md-inline-block">Items</span>
            </button>

            <button class="btn btn-outline- me-2 px-2 px-md-4">
                <div>
                    <span class=" text-success"><i class="fa-solid fa-check"></i></span>
                    <span class="d-inline-block text-success correct">0</span>
                </div>
                <span class="d-none d-md-inline-block">
                    Correct
                </span>
            </button>

            <button class="btn btn-outline- me-2 px-2 px-md-4">
                <div>
                    <span class=" text-danger"><i class="fa-sharp fa-solid fa-xmark"></i></span>
                    <span class="d-inline-block text-danger incorrect">0</span>
                </div>
                <span class="d-none d-md-inline-block ">
                    Incorrect
                </span>
            </button>
            <button class="btn btn-outline- me-2 px-2 px-md-4">
                <div>
                    <span class="text-warning"><i class="fa-sharp fa-solid fa-eye-slash"></i></span>
                    <span class="d-inline-block text-warning unat"></span>
                </div>
                <span class="d-none d-md-inline-block">
                    Unattempted
                </span>
            </button>
        </div>
    </div>

    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table">

                <tbody>

                </tbody>
            </table>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            // FETCHING DATA FROM JSON FILE
            $.getJSON("file.json",
                function (data) {
                    var tb = '';

                    // ITERATING THROUGH OBJECTS
                    $.each(data, function (key, value) {

                        //CONSTRUCTION OF ROWS HAVING
                        // DATA FROM JSON OBJECT
                        tb += `<tr>`;
                        tb += `<td class="align-middle position-relative">
                        <div class="d-flex justify-content-center">
                        <div class="circle d-inline-block float-left"> ${key + 1}
                        </div>
                        </div>
                        </td>`
                        tb += `<td>
                        <div class="d-flex justify-content-center">
                        <a href="ques.php/?review=1&no=${key + 1}" class=" review_page text-decoration-none text-dark ">  ${value.snippet} </a>
                        </div>
                        </td>`;

                        tb += `<td class="text-center align-middle">
                        <div class="d-flex justify-content-center">
                        <div class="circle corr_incorr" id="${key}0">A</div>
                        <div class="circle corr_incorr"id="${key}1">B</div>
                        <div class="circle corr_incorr" id="${key}2"> C</div>
                        <div class="circle corr_incorr" id="${key}3">D</div>
                        </div>
                        </td>`;
                        tb += `<td class="output${key}"></td>`;
                        tb += '</tr>';
                    });

                    //INSERTING ROWS INTO TABLE 
                    $('#table').append(tb);
                    var total = 0;
                    var Incorrect_count = 0;
                    var Unattempted_count = 0;
                    var data_index = 0;
                    var n = JSON.parse(data[data_index]['content_text']);


                    for (loop = 0; loop < data.length; loop++) {



                        output = sessionStorage.getItem("option" + loop);
                        check_result = sessionStorage.getItem("result" + loop);

                        if (output !== null) {
                            $(".output" + loop).append("attempted").addClass("bg-success").css("color", "white");
                        } else {
                            $(".output" + loop).append("unattempted").addClass("bg-warning").css("color", "white");
                        }


                        if (check_result == 1) {
                            total++;

                            $('.correct').text(total);
                        }
                        if (check_result == 0) {
                            Incorrect_count++;

                            

                            $('.incorrect').text(Incorrect_count);
                        }

                        if ($('.output' + loop).text() == 'unattempted') {
                            Unattempted_count++;
                        }
                        // sessionStorage.setItem("unattempted_session", "Unattempted_count");
                        $('.unat').text(Unattempted_count)
                        $('.items').text(data.length);
                        $('.result').text(
                            (parseFloat(total / ( data.length) * (100)).toFixed(2) + "%")
                        );

                       
                            for (i = 0; i < n.answers.length ; i++) {
                                if (JSON.parse(data[loop]["content_text"]).answers[i]['is_correct'] == '1' && JSON.parse(data[loop]["content_text"]).answers[i]['is_correct'] !== '0') {
                                    $(`#${loop}${i}`).addClass('bg-success');
                                }
                            if ((sessionStorage.getItem("option" + loop)) == i && (JSON.parse(data[loop]["content_text"]).answers[i]['is_correct'] == '0' ) ) {
                                $(`#${loop}${i}`).addClass('bg-danger');
                            }
                        }
                    }
                });
        });
    </script>



</body>

</html>