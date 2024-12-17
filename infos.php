<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="infos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="infos.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stundenplan</title>
</head>
<body>
  <nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Homepage</a>
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
              <a class="nav-link" href="stundenplan.php">Timetable</a>
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
    function changeForm(value){
      var js_value = value;
      window.location.href = "filter.php?js_value=" + js_value;
    }
  </script>

    <div class="filter">
      <label for="form-select">Filter</label>
      <?php

        include "database.php";
        $sql = "SELECT * FROM filter";
        $stmt = $pdo->query($sql)->fetch();
        if($stmt["ln"] == 1){
          ?>
          <select onchange="changeForm(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
            <option value="1" selected>last name</option>
            <option value="2">first name</option>
            <option value="3">subject 1</option>
            <option value="4">subject 2</option>
          </select>
          <?php
          $filter = 1;
        }
        else if($stmt["fn"] == 1){
          ?>
          <select onchange="changeForm(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
            <option value="1">last name</option>
            <option value="2" selected>first name</option>
            <option value="3">subject 1</option>
            <option value="4">subject 2</option>
          </select>
          <?php
          $filter = 2;
        }
        else if($stmt["s1"] == 1){
          ?>
          <select onchange="changeForm(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
            <option value="1">last name</option>
            <option value="2">first name</option>
            <option value="3" selected>subject 1</option>
            <option value="4">subject 2</option>
          </select>
          <?php
          $filter = 3;
        }
        else if($stmt["s2"] == 1){
          ?>
          <select onchange="changeForm(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
            <option value="1">last name</option>
            <option value="2">first name</option>
            <option value="3">subject 1</option>
            <option value="4" selected>subject 2</option>
          </select>
          <?php
          $filter = 4;
        }
      ?>
      <div class="search-bar-container" style="margin-left: 10px;">
        <input type="search" placeholder="Search..." oninput="search()" id="search">
      </div>
    </div>
    

      <div style="display: flex; flex-direction: row;" class="teacher-card">
        <div class="card_add">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Teacher</h5>
              <p class="card-text">Some quick information on your teacher</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">subject 1</li>
              <li class="list-group-item">subject 2</li>
            </ul>
            <div class="card-body">
                <button type="submit" class="btn-close" aria-label="Close"></button>
            </div>
          </div>
        </div>
					<?php
					  include "database.php";
						
						  
						  $id = $_SESSION["userID"];
              if($filter == 1){
                $stmt = $pdo->query("SELECT * FROM teacher WHERE createdBY = $id ORDER BY name");
              }
              else if($filter == 2){
                $stmt = $pdo->query("SELECT * FROM teacher WHERE createdBY = $id ORDER BY vorname");
              }
              else if($filter == 3){
                $stmt = $pdo->query("SELECT teacher.*, subject.subject_name FROM teacher JOIN subject ON teacher.subjectID1 = subject.ID WHERE teacher.createdBY = $id ORDER BY subject.subject_name");
              }
              else if($filter == 4){
                $stmt = $pdo->query("SELECT teacher.*, subject.subject_name FROM teacher JOIN subject ON teacher.subjectID2 = subject.ID WHERE teacher.createdBY = $id ORDER BY subject.subject_name");
              }

						  while($row = $stmt->fetch()){
                $id1 = $row['subjectID1'];
                $id2 = $row['subjectID2'];
                $sqlID1 = $pdo->query("SELECT subject_name FROM subject WHERE ID = $id1");
                $sqlID2 = $sqlID1->fetch();
                $sqlID3 = $pdo->query("SELECT subject_name FROM subject WHERE ID = $id2");
                $sqlID4 = $sqlID3->fetch();
                ?>
							  <div class="card_add" id=<?php echo $row['name'] ?>>
          			  <div class="card" style="width: 18rem;">
            			  <div class="card-body">
              			  <h5 class="card-title"><?php echo $row['name'],", ", $row['vorname'] ?></h5>
              			  <p class="card-text"><?php echo $row["discription"] ?></p>
            			  </div>
            		    <ul class="list-group list-group-flush">
              		    <li class="list-group-item"><?php echo $sqlID2["subject_name"] ?></li>
              		    <li class="list-group-item"><?php echo $sqlID4["subject_name"] ?></li>
            		    </ul>
            		    <div class="card-body">
              		    <form action="teacher_delete.php?teacherID=<?php echo $row['id'] ?>" method="post">
                        <button type="submit" class="btn-close" aria-label="Close"></button>
                      </form>
            		    </div>
                  </div>
                  
          		  </div>
              <?php
						}
					?>
          <button type="button" class="btnbtn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-top: 180px; margin-left: 50px; width: 80px; height: 80px; background: none; border: none;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
          </svg></button>

      </div>

          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">New Teacher</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="teacher_add.php" method="post">
                      <div class="input-group mb-3">
                        <span class="input-group-text">first name</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="first name" name="first_name">
                        <span class="input-group-text">last name</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="last name" name="last_name">
                      </div>
                      <select class="form-select" aria-label="Default select example" name="s1">
                        <option selected>Open this select menu</option>
                        <?php

                          include "database.php";

                          $stmt = $pdo->query("SELECT * FROM subject ORDER BY subject_name");
                          while($row = $stmt->fetch()){
                            ?>
                            <option value = <?php echo $row["ID"]?>><?php echo $row["subject_name"]?></option>
                            <?php
                          }
                        ?>
                      </select>
                      <select class="form-select" aria-label="Default select example" name="s2">
                        <option selected>Open this select menu</option>
                        <?php
                          include "database.php";
                          $stmt = $pdo->query("SELECT * FROM subject ORDER BY subject_name");
                          while($row = $stmt->fetch()){
                            ?>
                            <option value = <?php echo $row["ID"]?>><?php echo $row["subject_name"]?></option>
                            <?php
                          }
                        ?>
                      </select>
                      <div class="input-group mb-3">
                        <span class="input-group-text">little discription</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="discription" name="discription">
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
      <hr>
      <script>
        function changeForm_room(value){
          window.location.href = "room_filter.php?value=" + value;
        }
      </script>

      <div class="filter"> 
        <label for="filter">Filter</label>
        <?php
        include "database.php";

        $sql = "SELECT * FROM filterroom";
        $stmt = $pdo->query($sql)->fetch();
        if($stmt["building"] == 1){
          ?>
          <select onchange="changeForm_room(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
          <option value="1" selected>building</option>
          <option value="2">number</option>
          <option value="3">description</option>
        </select> 
        <?php
        $filterroom = 1;
        }
        else if($stmt["number"] == 1){
          ?>
          <select onchange="changeForm_room(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
          <option value="1">building</option>
          <option value="2" selected>number</option>
          <option value="3">description</option>
        </select> 
        <?php
        $filterroom = 2;
        }
        else if($stmt["description"] == 1){
          ?>
          <select onchange="changeForm_room(this.value)" class="form-select" aria-label="Default select example" id="filter" name="filter" style="width: 200px;">
          <option value="1">building</option>
          <option value="2">number</option>
          <option value="3" selected>description</option>
        </select> 
        <?php
        $filterroom = 3;
        }
        ?>
        
      </div>
      <div class="room-cards" style="display:flex; flex-direction: row">
        <div class="card_add">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Room</h5>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">room name</li>
            </ul>
            <div class="card-body">
              <button type="submit" class="btn-close" aria-label="Close"></button>
            </div>
          </div>
        </div>
        
        <?php

        include "database.php";
        $createdBY = intval($_SESSION["userID"]);
        if($filterroom == 1){
          $sqlRoom = $pdo->query("SELECT * FROM room WHERE createdBY = $createdBY ORDER BY building");
        }
        else if($filterroom == 2){
          $sqlRoom = $pdo->query("SELECT * FROM room WHERE createdBY = $createdBY ORDER BY room ");
        }
        else if($filterroom == 3){
          $sqlRoom = $pdo->query("SELECT * FROM room WHERE createdBY = $createdBY ORDER BY description");
        }
        

        While($row = $sqlRoom->fetch()){
          ?>
            <div class="room-cards" style="display:flex; flex-direction: row">
              <div class="card_add" id=<?php echo $row['building'], $row['room'] ?>>
                <div class="card" style="width: 18rem;">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $row["building"], $row["room"]; ?></h5>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $row["description"]; ?></li>
                  </ul>
                  <form action="room_delete.php?roomID=<?php echo $row["roomID"] ?>" method="POST">
                    <div class="card-body">
                      <button type="submit" class="btn-close" aria-label="Close"></button>
                    </div>
                  </form>
                  
                </div>
              </div>
            </div>
          <?php
        }

        ?>
        <button type="button" class="btnbtn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_room" style="margin-top: 180px; margin-left: 50px; width: 80px; height: 80px; background: none; border: none;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
        </button>
      </div>
      <div class="modal fade" id="exampleModal_room" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">New Room</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="room_add.php" method="post">
                      <div class="input-group mb-3">
                        <span class="input-group-text">Building (char)</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="building" name="building">
                        <span class="input-group-text">number</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="number" name="number">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text">room name (description)</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="discription" name="discription">
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
    <hr> 
    <div class="subject-cards" style="display:flex; flex-direction: row">
      <div class="card_add">
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Subject</h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">color</li>
          </ul>
          <div class="card-body">
            <button type="submit" class="btn-close" aria-label="Close"></button>
          </div>
        </div>
      </div>
    

    <?php

        include "database.php";
        
        $sqlSubject = $pdo->query("SELECT * FROM subject WHERE createdBy = $_SESSION[userID] OR createdBy = 0 ORDER BY subject_name");
        While($row = $sqlSubject->fetch()){

    ?>

    <div class="subject-cards" style="display:flex; flex-direction: row">
      <div class="card_add"  id=<?php echo $row['subject_name'] ?>>
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row["subject_name"]; ?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><?php echo $row["color"]; ?></li>
          </ul>
          <?php
            if($row['editable'] == 0){
              ?>
              <div class="card-body">
              <button type="submit" class="btn-close" aria-label="Close"></button>
            </div>
            <?php
            }else{
              ?>
              <form action="subject_delete.php?subjectID=<?php echo $row["ID"] ?>" method="POST">
                <div class="card-body">
                  <button type="submit" class="btn-close" aria-label="Close"></button>
                </div>
              </form>
              <?php
            }
          ?>
          
                  
        </div>
      </div>
    </div>
    

    <?php
        }
    ?>
      <button type="button" class="btnbtn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_subject" style="margin-top: 180px; margin-left: 50px; width: 80px; height: 80px; background: none; border: none;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
      </button>
    </div>
    <div class="modal fade" id="exampleModal_subject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">New subject</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="subject_add.php" method="post">
                      <div class="input-group mb-3">
                        <span class="input-group-text">subject name</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="name" name="name">
                        <span class="input-group-text">color</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="color" name="color">
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
  <?php
  ?>
  
  <br><br><br>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>