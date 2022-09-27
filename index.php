<?php  

// INSERT INTO `notes` (`Sr.No.`, `Title`, `Description`, `TIme`) VALUES ('1', 'important', 'I have to complete this work in 1 hour because I have some other work to do. ', current_timestamp());

$insert = false;
$update = false;
$delete = false;
// Connecting to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername, $username, $password, $database);

// Die if not connected

if (!$conn){
  die ("Connection is not established". mysqli_connect_error());
} 

if (isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM notes WHERE `notes`.`Sr.No.` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset($_POST['snoEdit'])){
    // echo "Yes";
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $desc = $_POST['descEdit'];

    $sql = "UPDATE `notes` SET `Title` = '$title' , `Description` = '$desc' WHERE `notes`.`Sr.No.` = '$sno'";
    $result = mysqli_query($conn, $sql);

    if ($result){
      // echo "The record saved Successfully";
       $update = true;
      }else{
       echo "The record missed out";
      }

  } 
  else{
     $title = $_POST['title'];
     $desc = $_POST['desc'];

      $sql = "INSERT INTO `notes` (`Title`, `Description`, `TIme`) VALUES ('$title', '$desc', current_timestamp())";
      $result = mysqli_query($conn, $sql);

     if ($result){
     // echo "The record saved Successfully";
      $insert = true;
     }else{
      echo "The record missed out";
     }
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <title>PHP CRUD</title>
    
  </head>
  <body>

  <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModallLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php" method="post">
        <div class="form-group">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <label for="title">Note Title</label>
          <input type="title" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="desc">Note Description</label>
          <textarea class="form-control" name="descEdit" id="descEdit" rows="5"></textarea>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#"><img src="/crud/notes.png" height="35px" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <?php
    if ($insert){
       echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Your note is created successfully.
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
    }
    ?>
    <?php
    if ($update){
       echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Your note is updated successfully.
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
    }
    ?>
    <?php
    if ($delete){
       echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Your note is deleted successfully.
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
    }
    ?>
    

    <div class="container my-4">
      <h2>Add a Note</h2>
      <form action="/crud/index.php" method="post">
        <div class="form-group">
          <label for="title">Note Title</label>
          <input type="title" name="title" class="form-control" id="title" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="desc">Note Description</label>
          <textarea class="form-control" name="desc" id="desc" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>

    <div class="container my-4" >

     <?php
   /* $sql = "SELECT * FROM `notes`";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)){
      echo $row['Sr.No.'] . " Title is " . $row['Title'] . " Description is ". $row['Description'];
    }
    echo "<br>";

    if ($result){
      // echo "Record inserted successfully";
      $insert = true;
    } else {
      echo "Record is npt inserted properly";
    }*/
    ?> 

<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sr.No.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $sql = "SELECT * FROM `notes`";
    $sno = 0;
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)){
      $sno = $sno + 1;
      echo "<tr>
      <th scope='row'>". $sno ."</th>
      <td>". $row['Title'] ."</td>
      <td>". $row['Description'] ."</td>
      <td><button class='btn btn-sm btn-primary edit' id=". $row['Sr.No.'] .">Edit</button> <button class='btn btn-sm btn-primary delete' id=d".$row['Sr.No.'].">Delete</button>
    </tr>";
      
      
    }
    echo "<br>";
    ?>
  </tbody>
</table>
    </div>
    <hr> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
       $('#myTable').DataTable();
     } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((elements)=>{
        elements.addEventListener("click", (e)=>{
          console.log("edits", );
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          titleEdit.value = title;
          descEdit.value = description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((elements)=>{
        elements.addEventListener("click", (e)=>{
          console.log("edits", );
          sno = e.target.id.substr(1,);
           
          if (confirm("You really want to delete this Note !")){
            console.log("Yes");
            window.location = `/crud/index.php?delete=${sno}`;
            // create a form and submit it as a post request
          } else {
            console.log("No");
          }
        })
      })
    </script>
  </body>
</html>