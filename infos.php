<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="jquery-1.7.1.min.js"></script>
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
              <a class="nav-link" href="stundenplan.html">Timetable</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user.html">User</a>
              </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <main>

  <script>
    function changeForm(value){
      var js_value = value;
      window.location.href = "filter.php?js_value=" + js_value;
    }
  </script>

    <div class="filter">
      <label for="form-select">Filter</label>
      <?php
      
        $dbconfig['host'] = 'localhost';
        $dbconfig['user'] = 'root';
        $dbconfig['base'] = 'login';
        $dbconfig['pass'] = '';
        $dbconfig['char'] = 'utf8';
                      
        try {
          $pdo = new
          PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
          $dbconfig['user'], $dbconfig['pass']);
        }
        catch(PDOException $e) {
          exit('Unable to connect Database.');
        }

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
					  $dbconfig['host'] = 'localhost';
					  $dbconfig['user'] = 'root';
            $dbconfig['base'] = 'login';
            $dbconfig['pass'] = '';
            $dbconfig['char'] = 'utf8';
                          
            try {
              $pdo = new
              PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
              $dbconfig['user'], $dbconfig['pass']);
            }
            catch(PDOException $e) {
              exit('Unable to connect Database.');
            }
						
						  session_start();
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
							  <div class="card_add">
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
                          $dbconfig['host'] = 'localhost';
                          $dbconfig['user'] = 'root';
                          $dbconfig['base'] = 'login';
                          $dbconfig['pass'] = '';
                          $dbconfig['char'] = 'utf8';
                          
                          try {
                              $pdo = new
                              PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
                              $dbconfig['user'], $dbconfig['pass']);
                          }
                          catch(PDOException $e) {
                              exit('Unable to connect Database.');
                          }
                          $stmt = $pdo->query("SELECT subject_name FROM subject ORDER BY subject_name");
                          $zaehler = 1;
                          while($row = $stmt->fetch()){
                            ?>
                            <option value = <?php echo $zaehler?>><?php echo $row["subject_name"]?></option>
                            <?php
                            $zaehler += 1;
                          }
                        ?>
                      </select>
                      <select class="form-select" aria-label="Default select example" name="s2">
                        <option selected>Open this select menu</option>
                        <?php
                          $dbconfig['host'] = 'localhost';
                          $dbconfig['user'] = 'root';
                          $dbconfig['base'] = 'login';
                          $dbconfig['pass'] = '';
                          $dbconfig['char'] = 'utf8';
                          
                          try {
                              $pdo = new
                              PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
                              $dbconfig['user'], $dbconfig['pass']);
                          }
                          catch(PDOException $e) {
                              exit('Unable to connect Database.');
                          }
                          $stmt = $pdo->query("SELECT subject_name FROM subject ORDER BY subject_name");
                          $zaehler = 1;
                          while($row = $stmt->fetch()){
                            ?>
                            <option value = <?php echo $zaehler?>><?php echo $row["subject_name"]?></option>
                            <?php
                            $zaehler += 1;
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
      <div class="room-cards" style="display:flex; flex-direction: row">
        <div class="card_add">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Room</h5>
              <p class="card-text">Some quick information on this room</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">room name</li>
            </ul>
            <div class="card-body">
              <button type="submit" class="btn-close" aria-label="Close"></button>
            </div>
          </div>
        </div>
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
                        <input type="text" class="form-control" placeholder="..." aria-label="builing" name="building">
                        <span class="input-group-text">number</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="number" name="number">
                      </div>
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
          
          
  </main>
    
</body>
</html>