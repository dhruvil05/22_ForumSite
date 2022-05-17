<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Welcome to Talking - coding forum</title>
    <style>
    .media {
        display: flex;
    }

    .userImg {
        margin: 2px 5px;
    }
    </style>
</head>

<body>
    <?php include 'partial/_header.php';?>
    <?php include 'partial/_dbconnect.php';?>
    <?php 
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id= $id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];

        }
    ?>
    <?php
    $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];
            
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '0', current_timestamp())";

            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              
            }
        }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forum</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum for sharing knowledge with each other.</p>
            <a href="" class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <?php
     if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){
    echo '<div class="container">
        
       
        <form action="'. $_SERVER['REQUEST_URI'] . '" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Question title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                    placeholder="Enter thread title">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                    possible</small>
            </div>
            <div class="form-group mt-3">
                <label for="exampleFormControlTextarea1">Ellaborate your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
    
    </div>';
     }
     else{
         echo ' <div class="container">
         <h1>Start a Discussion</h1>
         <p class="lead" style="color:red">you are not logged in. please login to be able to start a discussion</p>
    </div>

            ';

     }
    ?>

    <div class="container">
        <h1>Browse Questions</h1>
        <?php 
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id= $id ";
            $result = mysqli_query($conn,$sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $noResult = false;
                // $thread_time = $row['timestamp']; 
                // $thread_user_id = $row['thread_user_id'];   

                // $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                // $result2 = mysqli_query($conn,$sql2);
                // $row2 = mysqli_fetch_assoc($result2);

            

                echo '<div class="media my-3">
                    <img src="img/userdefault.png" width="54px" alt="..." class="mr-3 userImg">
                    <div class="media-body">
                    <h5 class="userTitle"><a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                        ' . $desc . '
                    </div>
                </div>';    
            }
       
            
            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                        <h1 class="display-4">No Treads Found</h1>
                        <p class="lead">Be the first persone to ask quetion.</p>
                        </div>
                    </div>';
            }
        ?>


    </div>
    <?php include 'partial/_footer.php'?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>