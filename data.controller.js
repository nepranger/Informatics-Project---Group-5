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
                            $window.location.href = "login.html";
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
        
        $scope.getAndSetSession = function(newSession) {
            console.log('Set session', newSession);
            newSession.month = newSession.available_date.getMonth()+1; // Thinks Jan is 0th month
            newSession.day = newSession.available_date.getDay();
            newSession.year = newSession.available_date.getYear();
            
            $http.post('addSession.php')
                .then(function (response) {
          
                });
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
                              $window.location.href = "AdminHome.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
        
        // function to edit user data and send it to web api to edit the user in the database
        $scope.editUser = function(userDetails) {
          var movieupload = angular.copy(userDetails);
          
          $http.post("editUser.php", movieupload)
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
