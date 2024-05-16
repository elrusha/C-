<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Translator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-**********************" crossorigin="anonymous">

    <style>
        /* Your CSS styles here */
        body {
            background-image: url('imag.png'); 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin-top: 20px;
        }
        .card {
            margin-top: 50px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: linear-gradient(to right, #800080, #4B0082);
        }
        .card-header {
            color: #fff;
            border-radius: 15px 15px 0 0;
            text-align: center;
            padding: 20px 0;
            font-size: 1.5rem;
        }
        .card-body {
            padding: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            background-color: rgba(255, 255, 255, 0.8); 
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #ced4da;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            font-size: 1.2rem;
            color: #333;
        }
        input[type="text"].form-control {
            background-color: #f8f9fa;
        }
        .result {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px;
            margin-top: 20px; 
        }
        .result p {
            margin-bottom: 0;
        }
        .textToSpeech {
            margin-top: 10px;
        }
        .col-md-12 {
            width: auto;
            margin: auto;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        TRANSLATE-TULU
                    </div>
                    <div class="col-md-12">
                        <select id="option" onchange="toggleForm()">
                            <option value="english_to_tulu">English to Tulu</option>
                            <option value="tulu_to_english">Tulu to English</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <div id="form1" style="display: none;">
                            <form action="" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" name="english" value="<?php if(isset($_GET['english'])){echo $_GET['english'];} ?>" class="form-control" placeholder="Enter English Word">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Translate</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="form2" style="display: none;">
                            <form action="" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" name="tulu" value="<?php if(isset($_GET['tulu'])){echo $_GET['tulu'];} ?>" class="form-control" placeholder="Enter Tulu Word">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Translate</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Translation Results -->
                        <div id="translationResults" style="display: none;">
                            <?php 
                            // Your PHP code to display translation results goes here
                            $con = mysqli_connect("localhost","root","","translate");
                        
                            if(isset($_GET['english']))
                            {
                                $english = $_GET['english'];
                                $option = $_GET['option'];
                        
                                if ($option === "english_to_tulu") {
                                    $query = "SELECT * FROM tulu WHERE english='$english' ";
                                } else if ($option === "tulu_to_english") {
                                    $query = "SELECT * FROM tulu WHERE tulu='$english' ";
                                }
                        
                                $query_run = mysqli_query($con, $query);
                        
                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    foreach($query_run as $row)
                                    {
                            ?>
                            <div class="row">
                                <div class="col-md-12 result">
                                    <hr>
                                    <div class="form-group mb-3">
                                        <?php if ($option === "english_to_tulu"): ?>
                                        <label for="">English</label>
                                        <input type="text" value="<?= $row['english']; ?>" class="form-control" readonly>
                                        <?php elseif ($option === "tulu_to_english"): ?>
                                        <label for="">Tulu</label>
                                        <input type="text" id="tu" value="<?= $row['tulu']; ?>" class="form-control" readonly>
                                        <?php endif; ?>
                                    </div>
                        
                                   
                        
                        
                                    <div class="form-group mb-3">
                                        <?php if ($option === "english_to_tulu"): ?>
                                        <label for="">Tulu</label>
                                        <input type="text" id="tu" value="<?= $row['tulu']; ?>" class="form-control" readonly>
                                        <?php elseif ($option === "tulu_to_english"): ?>
                                        <label for="">English</label>
                                        <input type="text" value="<?= $row['english']; ?>" class="form-control" readonly>
                                        <?php endif; ?>
                                        <button type="button" id="textToSpeech" class="btn btn-primary btn-sm"><i class="fas fa-volume-up"></i> Speak</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                                else
                                {
                                    echo "<p>No Record Found</p>";
                                }
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            var option = document.getElementById("option").value;
            if (option === "english_to_tulu") {
                document.getElementById("form1").style.display = "block";
                document.getElementById("form2").style.display = "none";
            } else if (option === "tulu_to_english") {
                document.getElementById("form1").style.display = "none";
                document.getElementById("form2").style.display = "block";
            }
        }

        // Function to show translation results
        function showTranslationResults() {
            document.getElementById("translationResults").style.display = "block";
        }
    </script>
</body>
</html>









