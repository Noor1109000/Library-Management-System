
<?php
	session_start();
	include("dbConfig.php");
	error_reporting(0);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Online Library Management</title>
		<link rel="stylesheet" type="text/css" href="../css/home.css">
		<link rel="stylesheet" type="text/css" href="../css/title.css">
	</head>
	<body>
		<div class="container">
			<div class="header">
				<?php include("header.php"); ?>
			</div>

			<div class="navigation">
				<?php include("navigation.php"); ?>
			</div>

			<div class="content">
				<?php
				//ACTIVITY PERFORM...

					$activity = $_REQUEST['activity'];

					switch ($activity) {
						case 'dashboard':
							include("dashboard.php");
							break;

						case 'search':
							include("search.php");
							break;

						case 'adminLogin':
							include("adminLogin.php ");
							break;
						
						case 'studentLogin':
							include("studentLogin.php");
							break;

						case 'facultyLogin':
							include("facultyLogin.php");
							break;

						case 'register':
							include("register.php");
							break;

						case 'userDashboard':
							include("userDashboard.php");
							break;

						case 'issueBooks':
							include("issueBooks.php");
							break;

						case 'returnBooks':
							include("returnBooks.php");
							break;

						case 'issuedBooks':
							include("issuedBooks.php");
							break;

						case 'returnedBooks':
							include("returnedBooks.php");
							break;

						case 'forgetpwd':
							include("forgetpwd.php");
							break;

						default:
							# code...
							break;
					}

				?>

				<?php
				//ADMIN LOGIN...

					if(isset($_REQUEST['adminLoginBtn'])){
		
						$username= $_REQUEST['username'];
						$pwd= $_REQUEST['pwd'];

						if(!empty($username) && !empty($pwd)){

							$query = mysql_query("SELECT id,username,pwd FROM admin WHERE username = '$username'");
							$result = mysql_fetch_assoc($query);

								if($username == $result['username'] && $pwd == $result['pwd']){
				
									$_SESSION['username'] = $result['username'];
									$_SESSION['uid'] = $result['id'];

									header("location: admin/adminPage.php?activity=adminDashboard");
								}
								else{
									include("adminLogin.php");
									$errorMsg = "Invalid User....";
								}
						}
						else{
							include("adminLogin.php");
							$errorMsg = "Enter in empty field...";
						}
						
					}

				?>

				<?php
				//STUDENT LOGIN...

					if(isset($_REQUEST['studentLoginBtn'])){
		
						$username= $_REQUEST['username'];
						$pwd= $_REQUEST['pwd'];

						if(!empty($username) && !empty($pwd)){

							$query = mysql_query("SELECT id,username,pwd FROM members WHERE position = 'Student' && username = '$username' && pwd = '$pwd'");
							$result = mysql_fetch_assoc($query);

								if($username == $result['username'] && $pwd == $result['pwd']){
				
									$_SESSION['username'] = $username;
									$_SESSION['uid'] = $result['id'];

									header("location: members/userPage.php?activity=viewProfile");
								}
								else{
									include("studentLogin.php");
									$errorMsg = "Invalid User....";
								}
						}
						else{
							include("studentLogin.php");
							$errorMsg = "Enter in empty field...";
						}
						
					}

				?>

				<?php
				//FACULTY LOGIN...

					if(isset($_REQUEST['facultyLoginBtn'])){
		
						$username= $_REQUEST['username'];
						$pwd= $_REQUEST['pwd'];

						if(!empty($username) && !empty($pwd)){

							$query = mysql_query("SELECT id,username,pwd FROM members WHERE position = 'Faculty' && username = '$username' && pwd = '$pwd'");
							$result = mysql_fetch_assoc($query);

								if($username == $result['username'] && $pwd == $result['pwd']){
				
									$_SESSION['username'] = $username;
									$_SESSION['uid'] = $result['id'];

									header("location: members/userPage.php?activity=viewProfile");
								}
								else{
									include("facultyLogin.php");
									$errorMsg = "Invalid User....";
								}
						}
						else{
							include("facultyLogin.php");
							$errorMsg = "Enter in empty field...";
						}
						
					}

				?>

				<?php
				//ADD MEMBER...
					             
                    $query = "Select Max(id) From members";
                    $returnD = mysql_query($query);
                    $result = mysql_fetch_assoc($returnD);
                    $maxRows = $result['Max(id)'];
                    if(empty($maxRows)){
                        $lastRow = $maxRows = 1;      
                    }else{
                        $lastRow = $maxRows + 1 ;
                    }

                    if(isset($_REQUEST['addMemberBtn'])){

                        $memberId = $_REQUEST['memberId'];
                        $firstName = $_REQUEST['firstName'];
                        $lastName = $_REQUEST['lastName'];
                        $username = $_REQUEST['username'];
                        $pwd = $_REQUEST['pwd'];
                        $position = $_REQUEST['position'];
                        $mobile = $_REQUEST['mobile'];
						$email = $_REQUEST['email'];

						$fnm = $_FILES['fnm'];

						$actualFileName = $fnm['name'];
						$tmpName = $fnm['tmp_name'];
						//$type = $fnm['type'];
						//$size = $fnm['size'];
						//$error = $fnm['error'];
						$targetLocation = "members/pic/$actualFileName";

                        if(!empty($memberId) && !empty($firstName) && !empty($lastName) && !empty($username) && !empty($pwd) && !empty($mobile)){

                        	$usernameExists = mysql_fetch_assoc(mysql_query("SELECT username FROM members WHERE username = '$username'"));

                            if($usernameExists['username'] != $username){

                            	$mobileExists = mysql_fetch_assoc(mysql_query("SELECT mobile FROM members WHERE mobile = '$mobile'"));

                            	if($mobileExists['mobile'] != $mobile){

                            		$emailExists = mysql_fetch_assoc(mysql_query("SELECT email FROM members WHERE email = '$email'"));

                            		if($emailExists['email'] != $email){

		                            	move_uploaded_file($tmpName, $targetLocation);

		                                $query = "Insert Into members(id,firstName,lastName,username,pwd,position,mobile,email,pic) Values('$memberId','$firstName','$lastName','$username','$pwd','$position','$mobile','$email','$actualFileName')";
		                                $res = mysql_query($query);

		                                if(!empty($res)){
			                                $errorMsg = "Member Sucessfully Added.";
			                            }
			                                $query = "Select Max(id) From members";
			                                $returnD = mysql_query($query);
			                                $result = mysql_fetch_assoc($returnD);
			                                $maxRows = $result['Max(id)'];

			                                if(empty($maxRows)){
			                                    $lastRow = $maxRows = 1;      
			                                }else{
			                                    $lastRow = $maxRows + 1 ;
			                                }
		                            }
		                            else{
		                            	$errorMsg = "Email ID already exists. ";	
		                            }

		                        }
		                        else{
		                        	$errorMsg = "Mobile number already exists. ";
		                        }
                            }
                            else{
                                $errorMsg = "Username already exists.Choose another.";
                            }

                        }
                        else{
                            $errorMsg = "Please! Enter in Empty Field.";
                        }

                        include("register.php");
                    }

				?>

				<?php
                    //SEARCH BOOK OR STUDENT OR FACULTY USING THEIR NAME...

                        $searchList = $_REQUEST['searchList'];//SESSION['searchListValue'];
                        //echo $searchList;
                        if(isset($searchList)){

                            if($searchList == 'bookName'){

                                $searchField = $_REQUEST['searchField'];

                                if($searchField){

                                    $query = "SELECT bookId,title,author,price,available,catagory FROM books Where title LIKE '%$searchField%'";
                                    $returnD = mysql_query($query);
                                    $returnD1 = mysql_query($query);
                                    $result = mysql_fetch_assoc($returnD);

                                    if(empty($result)){
                                        $errorMsg = "Invalid Book Name...";
                                    }

                                }
                                else{
                                    $errorMsg = "Field can't be Empty...";
                                }

                            }
                            elseif($searchList == 'authorName'){

                                $searchField = $_REQUEST['searchField'];

                                if(!empty($searchField)){

                                     $query = "SELECT bookId,title,author,price,available,catagory FROM books Where author LIKE '%$searchField%'";
                                    $returnD = mysql_query($query);
                                    $returnD1 = mysql_query($query);
                                    $result = mysql_fetch_assoc($returnD);

                                    if(empty($result)){
                                        $errorMsg = "Invalid Author Name...";
                                    }

                                }
                                else{
                                    $errorMsg = "Field can't be Empty...";
                                }
                            }
							

							//catagory list
							
							if($searchList == 'bookCatagory'){

                                $searchField = $_REQUEST['searchField'];

                                if(!empty($searchField)){

                                     $query = "SELECT bookId,title,author,price,available,catagory FROM books Where catagory LIKE '%$searchField%'";
                                    $returnD = mysql_query($query);
                                    $returnD1 = mysql_query($query);
                                    $result = mysql_fetch_assoc($returnD);

                                    if(empty($result)){
                                        $errorMsg = "Invalid Catagory Name...";
                                    }

                                }
                                else{
                                    $errorMsg = "Field can't be Empty...";
                                }
                            }
							
							
							
							
							
							
							
							
							
                            elseif($searchList == 'bookId'){
                            	$searchField = $_REQUEST['searchField'];

                                if(!empty($searchField)){

                                     $query = "SELECT bookId,title,author,price,available,catagory FROM books Where bookId = '$searchField'";
                                    $returnD = mysql_query($query);
                                    $returnD1 = mysql_query($query);
                                    $result = mysql_fetch_assoc($returnD);

                                    if(empty($result)){
                                        $errorMsg = "Invalid Book-ID...";
                                    }

                                }
                                else{
                                    $errorMsg = "Field can't be Empty...";
                                }
                            }

                            include("search.php");
                        }
                ?>

                <?php
                //FORGET PASSWORD...

                	if(isset($_REQUEST['pwdSaveBtn'])){

                		$request = $_REQUEST['request'];

                		if($request == "admin"){
                			$regEmail = $_REQUEST['regEmail'];

							$query = mysql_query("SELECT email FROM admin WHERE email = '$regEmail'");
							$result = mysql_fetch_assoc($query);

							if($regEmail == $result['email']){

								$newP = $_REQUEST['newP'];
								$confirmP = $_REQUEST['confirmP'];

								if($newP == $confirmP){
									$query = mysql_query("UPDATE admin SET pwd = '$newP' WHERE email = '$regEmail'");

									if(!empty($query)){
										header("location: home.php?activity=adminLogin");
										//$errorMsg = "Password successfully changed.";
									}
								}
								else{
									//header("location: index.php?activity=forgetpwd");
									$errorMsg = "Password must be same.";
								}
							}
							else{
								//header("location: index.php?activity=forgetpwd");
								$errorMsg = "Please ! Enter authorised's user email.";
							}
                		}
                		else if($request == "user"){

							$regEmail = $_REQUEST['regEmail'];

							$query = mysql_query("SELECT email,position FROM members WHERE email = '$regEmail'");
							$result = mysql_fetch_assoc($query);

							if($regEmail == $result['email']){

								$newP = $_REQUEST['newP'];
								$confirmP = $_REQUEST['confirmP'];

								if($newP == $confirmP){

									$query = mysql_query("UPDATE members SET pwd = '$newP' WHERE email = '$regEmail'");

									if(!empty($query)){

										if($result['position'] == 'Student')
											header("location: home.php?activity=studentLogin");
										else if($result['position'] == 'Faculty')
											header("location: home.php?activity=facultyLogin");
										//$errorMsg = "Password successfully changed.";
									}
								}
								else{
									//header("location: index.php?activity=forgetpwd");
									$errorMsg = "Password must be same.";
								}
							}
							else{
								//header("location: index.php?activity=forgetpwd");
								$errorMsg = "Please ! Enter authorised's user email.";
							}
						}
						include("forgetpwd.php");
					}

                ?>

				<?php
		        if(isset($errorMsg)){
		            ?>
		            <div class="errorMsg"><?php echo $errorMsg; ?></div>
	                <?php	
	        	}
		  		?>

			</div>

			
			<div class="footer">
				<?php include("footer.php"); ?>
			</div>
		</div>
	</body>
</html>



