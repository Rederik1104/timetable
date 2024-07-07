<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="user.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stundenplan</title>
</head>
<body>
    <nav class="navbar bg-body-tertiary fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Account</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Timy</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="infos.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="stundenplan.html">Timetable</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user.php">User</a>
              </li>
              <li>
              <button onclick="logout()" style="text-decoration: none; border: none; background: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
              </button>
            </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <main>
          <script>
            function logout(){
              window.location.href = 'logout.php';
            }
          </script>
          <div class="email">
            <label for="email">E-Mail: </label>
            <label for="email_picture" id="emailAdresse">
              <?php
                
                $email = $_SESSION["userID"];
                
                include "database.php";

                $emailSQL = $pdo->query("SELECT email FROM users WHERE id = $email");
                while($row = $emailSQL->fetch()){
                  echo $row["email"];
                }
              ?>
            </label>
            <button type="button" class="btnbtn-primary" data-bs-toggle="modal" data-bs-target="#emailChange"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
          </button>
          </div>
          <div class="password">
            <label for="password">Password: </label>
            <label for="email_picture" id="password">
              <?php
                
                $email = $_SESSION["userID"];
                
                include "database.php";

                $emailSQL = $pdo->query("SELECT password FROM users WHERE id = $email");
                while($row = $emailSQL->fetch()){
                  echo "hashed: " . $row["password"];
                }
              ?>
            </label>
            <button type="button" class="btnbtn-primary" data-bs-toggle="modal" data-bs-target="#passwordChange"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
            </button>
          </div>
          <div class="schoolHour">
            <?php
              include("database.php");
              $sql = $pdo->prepare("SELECT length FROM hourLength WHERE createdBy = :id");
              $sql->bindParam(':id', $_SESSION["userID"]);
              $sql->execute();
              if ($row = $sql->fetch()) {
                $length = $row["length"];
              } else {
                $length = 45;
              }
              
            ?>
            <label for="schoolHour">School Hour: </label>
            <input type="number" min="45" max="90" id="schoolHour" value=<?=$length ?>>
            <button type="button" id="submitHour" onclick="changeHour()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
              <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
              </svg>
            </button>
          </div>

          <div class="modal fade" id="emailChange" tabindex="-1" aria-labelledby="#exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Change Your Email adresse</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="email_change.php" method="post">
                      <div class="input-group mb-3">
                        <span class="input-group-text">new Email</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="email1" name="email1">
                        <span class="input-group-text">confirm your Email</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="email2" name="email2">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div> 
                    </form>  
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="passwordChange" tabindex="-1" aria-labelledby="#exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Change Your Password</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="password_change.php" method="post">
                      <div class="input-group mb-3">
                        <span class="input-group-text">old Password</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="oPass" name="oPass">
                        <span class="input-group-text">new Password</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="nPass" name="nPass">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div> 
                    </form>  
                </div>
              </div>
            </div>
          </div>
    </main>
    <script src="user.js"></script>
    
</body>
</html>