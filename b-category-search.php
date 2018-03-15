<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>



</head>

<body>

<!-- Navigation Bar search function -->


<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="b-home.php">
        <img width="100" src="efast.png">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="col-md-auto">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="b-item-search.php" method="post" class="form-inline my-2 my-lg-0">
                <!--                        <input class="form-control mr-sm-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search">-->
                <div class="search-box">
                    <input type="text" autocomplete="off" placeholder="Search" id="search" name="search" />
                    <div class="result"></div>
                </div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" style="padding-left: 10px; padding-right: 10px ">
                    <input type="button" class="btn btn-primary navbar-btn" value="Search by category" onclick="window.location.href='b-category-search.php'" />
                    </a>
                    </li>


                </ul>
                <input class="btn btn-outline-success my-2 my-sm-0" type='submit' id="submit" name="submit" value="Search">
            </form>



        </div>
    </div>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li><a href="b-myprofile.php"><img height="30px" src="img/user1.png"> <?php echo "Hi "; echo  $_SESSION['first_name'] ; echo " "; echo   $_SESSION['last_name'] ;   ?> </a></li>
        </ul>
    </div>

    <button style="margin-left: 10px" type="button" onclick="window.location='logout.php';" class="btn btn-outline-danger btn-sm ">Logout</button>


</nav>



<style type="text/css">
    /* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        background-color: white;
        position: absolute;
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #20b5dd;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("backend-search.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result p", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>


<script type="text/javascript">
    function addToWatchlist() {

       var auction_id = document.getElementById("watchlistbtn").value;   

       var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText != ""){
                    alert(this.responseText);
                } else {
                    alert("Added to watchlist")
                }
                
            }
        };


        var parameters = "auctionID="+auction_id;
        xhttp.open("POST", "add-watchlist.php/?"+parameters, true);
        xhttp.send();



    }
</script>








<script>
function showUser() {
                
        var str = document.getElementById("changeByCategory").value;
        

        var xhttp;
        xhttp = new XMLHttpRequest();

        //changing of state 
        var w = document.getElementById("changeOfState");
        var changeState = w.options[w.selectedIndex].value;

        //exptime
        var r = document.getElementById("sortExpTime");
        var sortExp = r.options[r.selectedIndex].value;

        var parameters = "q="+str+"&changestate="+changeState+"&sortexp="+sortExp;
        xhttp.open("GET","category-results.php?"+parameters,true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
}

</script>









<div class="container">
    <br>
    <br>

<form >




<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="changeByCategory" onchange="showUser()">
  <option value="">Filter via category</option>

  <?php

$conn=mysqli_connect("efastdbs.mysql.database.azure.com", "efast@efastdbs", "Gv3-LST-nZU-JyP", "efast_main");

$sql="SELECT * FROM category";

$result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result)) {

        $cateID = $row['ID_CATEGORY'];
        $catename = $row['CATEGORY'];


        ?>

          <option value="<?php echo $cateID; ?>"><?php echo $catename; ?></option>


        <?php
    
    }


  ?>
  
  </select>


    <br>
  <br>


  <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="changeOfState" onchange="showUser()" >
  <option  value=" "> Filter by current state of item </option>
  <option  value="AND ID_STATE = 'STATE_01'"> NEW WITH SEALED BOX </option>
  <option  value="AND ID_STATE = 'STATE_02'"> NEW WITH OPENED BOX </option>
  <option  value="AND ID_STATE = 'STATE_03'"> NEW WITH DEFECTS </option>
  <option  value="AND ID_STATE = 'STATE_04'"> USED </option>
  </select>

    <br>
  <br>

  <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="sortExpTime" onchange="showUser()">
  <option  value=" "> Filter by expiry of item </option>
  <option  value="ORDER BY EXPIRATION_TIME DESC"> Sort by newest auctions </option>
  <option  value="ORDER BY EXPIRATION_TIME ASC"> Sort by auctions about to expire </option>
  </select>

</form>







</div>






<br>







<div class="container">
<div id="txtHint">
    <h1 align="center">Please select a category to return results</h1></div>

</div>



</body>

</html>