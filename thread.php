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
    <?php require 'partial/_header.php';?>
    <?php require 'partial/_dbconnect.php';?>
    <?php 
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id= $id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];

        }
    ?>
    <?php
    $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            // Insert into comment db
            $comment = $_POST['comment'];
            $sql = "INSERT INTO `comment` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '0', current_timestamp())";
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
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum for sharing knowledge with each other.</p>
            <p>posted by:<b> Dhruvil </b></p>
        </div>
    </div>
<?php
 if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){
   echo '<div class="container">
        <h1>Post a Comment</h1>
        <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">

            <div class="form-group mt-3">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
    </div>';
 }else{
    echo ' <div class="container">
    <h1>Post a comment</h1>
    <p class="lead" style="color:red">you are not logged in. please login to be able to post a comment</p>
</div> ';
 }
    ?>

    <div class="container">
        <h1>Discussions</h1>
        <?php 
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comment` WHERE thread_id= $id ";
            $result = mysqli_query($conn,$sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['comment_id'];
                $content = $row['comment_content']; 
                $comment_time = $row['comment_time'];
                $noResult = false;
                
                echo '<div class="media my-3">
                    <img src="img/userdefault.png" width="54px" alt="..." class="mr-3 userImg">
                    <div class="media-body">
                        <p class="font-weight-bold my-0"><b>Anonymous user at ' . $comment_time . '</b>
                        </p>' . $content . '
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