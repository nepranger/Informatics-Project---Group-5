/*
 *Controller where we get the data on the movies
 */
(function () {
    'use strict';

    var myApp = angular.module("project");
    myApp.controller("dataControl", function ($scope, $http, $window) {
        //Initialize data for the app
        init();

     

        function init() {
            $scope.menuHighlight = 0;  //this variable will hold the page number that should be highleted in the menu bar 0 is home.
            $scope.query = {};
            $scope.queryBy = "$";
            getAndSetAccounts();
            getAndSetStudents();
            getAndSetCourses();
            getAndSetTutors();
            getAndSetFaculty();
            getAndSetStudentCourses();
            getAndSetAvailableSessions();
            getAndSetScheduledSessions();
            getAndSetStudentProblemSet();
        }

        function getAndSetAccounts() {
            $http.get('getAccount.php')
                .then(function (response) {
                    $scope.accountData = response.data.value;
                    console.log($scope.accountData);
                });
        }

        function getAndSetStudents() {
            $http.get('getStudent.php')
                .then(function (response) {
                    $scope.studentData = response.data.value;
                    console.log($scope.studentData);
                });
        }
        function getAndSetTutors() {
            $http.get('getTutor.php')
                .then(function (response) {
                    $scope.tutorData = response.data.value;
                    console.log($scope.tutorData);
                });
        }


        function getAndSetCourses() {
            $http.get('getCourse.php')
                .then(function (response) {
                    $scope.courseData = response.data.value;
                    console.log($scope.courseData);
                });
        }
        function getAndSetFaculty() {
            $http.get('getFaculty.php')
                .then(function (response) {
                    $scope.facultyData = response.data.value;
                    console.log($scope.facultyData);
                });
        }
         function getAndSetStudentCourses() {
            $http.get('getStudentCourses.php')
                .then(function (response) {
                    $scope.scourseData = response.data.value;
                    console.log($scope.scourseData);
                });
        }
        
        function getAndSetStudentProblemSet() {
            $http.get('getStudentProblem.php')
                .then(function (response) {
                    $scope.studentProblemData = response.data.value;
                    console.log($scope.studentProblemData);
                });
        }
        
        function getAndSetAvailableSessions() {
            $http.get('getAvailableSessions.php')
                .then(function (response) {
                    $scope.availableSessionData = response.data.value;
                    console.log('available', $scope.availableSessionData);
                });
        }

        function getAndSetScheduledSessions() {
            $http.get('getScheduledSessions.php')
                .then(function (response) {
                    $scope.scheduledSessionData = response.data.value;
                    console.log('scheduled', $scope.scheduledSessionData);
                });
        }

        

        //some else if statements to handle different types of accounts
        //function to send new account information to web api to add it to the database
        $scope.login = function (accountDetails) {
            var accountupload = angular.copy(accountDetails);

            $http.post("login.php", accountupload)
                .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert('error:' + response.data.message);
                        } else {
                            //successful
                            if (response.data.accountType=="student") {
                                $window.location.href = "StudentHome.html";
                                console.log(response);
                            } else if (response.data.accountType=="tutor") {
                                $window.location.href = "TutorHome.html";
                            } else if (response.data.accountType=="faculty") {
                                $window.location.href = "FacultyHome.html";
                            } else if (response.data.isadmin) {
                                $window.location.href = "AdminHome.html";
                            } else {
                                alert('did not get expected response for account type');
                            }
                            //$window.location.href = "home.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        };

        //function to log the user out
        $scope.logout = function () {

            $http.post("logout.php")
                .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert('error:' + response.data.message);
                        } else {
                            //successful
                            $window.location.href = "index.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        };

        //function to check if user is logged in

        function checkifloggedin() {
            $http.post("isloggedin.php")
                .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.loggedin === true) {
                            //CAll function get get logged in user info
                            getLoggedInUser(response.data.username);

                            alert('error:' + response.data.message);
                        } else {
                            //successful
                            //set $scope.isloggedin based on whether the user is logged in or not
                            $scope.isloggedin = response.data;
                            console.log($scope.isloggedin);
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        }
        
        // setup an available tutor session
        $scope.setSession = function(newSession) {
            $http.post('addSession.php', newSession)
                .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert('error:' + response.data.message);
                        } else {
                            // successfully added session, refresh page
                            $window.location.href = "TutorHome.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        };

        // sign up for a tutoring session as a student
        $scope.signUpForSession = function(slot_ID) {
            $http.post('signUpForSession.php', slot_ID)
                .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert('error:' + response.data.message);
                        } else {
                            // successfully added session, refresh page
                            $window.location.href = "StudentHome.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        };

        // cancel a session whether student or tutor 
        $scope.cancelSession = function(session_ID, slot_ID) {
            var data = { 'session_ID': session_ID, 'slot_ID': slot_ID };

            $http.post('cancelSession.php', data)
                .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert('error:' + response.data.message);
                        } else {
                            // successfully cancelled session, refresh page
                            $window.location.reload();
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        };

        //delete an available session that hasn't been scheduled
        $scope.deleteAvailableSession = function(session_ID) {
            $http.post('deleteSession.php', session_ID)
                .then(function (response) {
                    console.log('response: ', response); // help check
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert('error:' + response.data.message);
                        } else {
                            // successfully deleted session, refresh page
                            $window.location.href = "TutorHome.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
        };
// function to delete a course. it receives the course name and call a php web api to complete deletion from the database
        $scope.deleteCourse = function(course_name) {
            if (confirm("Are you sure you want to delete " + course_name + "?")) {
          
                $http.post("deleteCourse.php", {"course_name" : course_name})
                  .then(function (response) {
                     if (response.status == 200) {
                          if (response.data.status == 'error') {
                              alert('error: ' + response.data.message);
                          } else {
                              // successful
                              // send user back to home page
                              $window.location.href = "managecourses.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
       

 // function to delete an accoubt. it receives the account name hawk_id and call a php web api to complete deletion from the database
        $scope.deleteUser = function(hawk_ID) {
            if (confirm("Are you sure you want to delete " + hawk_ID + "?")) {
          
                $http.post("deleteUser.php", {"hawk_ID" : hawk_ID})
                  .then(function (response) {
                     if (response.status == 200) {
                          if (response.data.status == 'error') {
                              alert('error: ' + response.data.message);
                          } else {
                              // successful
                              // send user back to home page
                              $window.location.href = "managestudent.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
// function to delete a tutor. it receives the account name hawk_id and call a php web api to complete deletion from the database
        $scope.deleteTutor = function(hawk_ID) {
            if (confirm("Are you sure you want to delete " + hawk_ID + "?")) {
          
                $http.post("deleteTutor.php", {"hawk_ID" : hawk_ID})
                  .then(function (response) {
                     if (response.status == 200) {
                          if (response.data.status == 'error') {
                              alert('error: ' + response.data.message);
                          } else {
                              // successful
                              // send user back to home page
                              $window.location.href = "managetutor.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
// function to delete a faculty memeber. it receives the account name hawk_id and call a php web api to complete deletion from the database
        $scope.deleteFaculty = function(hawk_ID) {
            if (confirm("Are you sure you want to delete " + hawk_ID + "?")) {
          
                $http.post("deleteFaculty.php", {"hawk_ID" : hawk_ID})
                  .then(function (response) {
                     if (response.status == 200) {
                          if (response.data.status == 'error') {
                              alert('error: ' + response.data.message);
                          } else {
                              // successful
                              // send user back to home page
                              $window.location.href = "managefaculty.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
        
        // function to send new account information to web api to add it to the database-- check admin html
        $scope.createNewAccount = function(accountDetails) {
          var accountupload = angular.copy(accountDetails);
          
          $http.post("newAccount.php", accountupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "AdminHome.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });
        };
          

        // function to send new account information to web api to add it to the database-- check admin html
        $scope.createNewFacultyPractice = function(facultyDetails) {
          var facultyupload = angular.copy(facultyDetails);
          
          $http.post("practice.php", facultyupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        
                        // successful
                        // send user back to home page
                        $window.location.href = "Facultypractice1.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });
        };
               
        //function getLoggedInUser(username) {
          //  console.log(username);
          //  $http.post("getUserInfo.php", username)
          //      .then(function (response) {
                    //assigment will be how you formatted in the php
                    //$scope.loggedInUser = {
                    //   username: ''
                    //};
         //           $scope.loggedInUser = response.data;
        //        });
        //}
        //THIS IS BEING CALLED EVERY TIME THE VIEW IS RELOADED
        //checkifloggedin();
    });
    
    
})();

