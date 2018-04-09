/*
 * Controller where we get the data on movies
 */
(function () {
    'use strict';
    
    // the 'movie' part comes from the name of the app we created in movie.module.js
    var myApp = angular.module("movie");
    
    // 'dataControl' is used in the html file when defning the ng-controller attribute
    myApp.controller("dataControl", function($scope, $http, $window) {
        
        // define data for the app
        // in the html code we will refer to data.players. The data part comes from $scope.data, the players part comes from the JSON object below
        
        $http.get('getmovies.php')
            .then(function(response) {
                // response.data.value has value come from the getplayers.php file $response['value']['players'] = $players;
                $scope.data = response.data.value;
            }
                   );
        
        $scope.query = {};
        $scope.queryBy = "$";
            
        // this variable will hold the page number that should be highlighted in the menu bar
        // 0 is for index.html
        // 1 is for newmovie.html
        $scope.menuHighlight = 0;
        
        
        // function to send new movie information to web api to add it to the database
        $scope.newMovie = function(movieDetails) {
          var movieupload = angular.copy(movieDetails);
          
          $http.post("newmovie.php", movieupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "index.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });
        };
        
        
        // function to delete a player. it receives the player's name and id and call a php web api to complete deletion from the database
        $scope.deleteMovie = function(title, id) {
            if (confirm("Are you sure you want to delete " + name + "?")) {
          
                $http.post("deletemovie.php", {"id" : id})
                  .then(function (response) {
                     if (response.status == 200) {
                          if (response.data.status == 'error') {
                              alert('error: ' + response.data.message);
                          } else {
                              // successful
                              // send user back to home page
                              $window.location.href = "index.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
         // function to edit player data and send it to web api to edit the player in the database
        $scope.editMovie = function(movieDetails) {
          var movieupload = angular.copy(movieDetails);
          
          $http.post("editmovie.php", movieupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "index.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });
        };
        

        /*
         * Set edit mode of a particular player
         * on is true if we are setting edit mode to be on, false otherwise
         * player corresponds to the player for which we are setting an edit mode
         */
        $scope.setEditMode = function(on, movie) {
            if (on) {
                // if player had a birth, for example, you'd include the line below
                // player.birthyear = parseInt(player.birthyear);
                // editplayer matches the ng-model used in the form we use to edit player information
                $scope.editmovie = angular.copy(movie);
                movie.editMode = true;
            } else {
                $scope.editmovie = null;
                movie.editMode = false;

            }
        };
        
        /*
         * Gets the edit mode for a particular player
         */
        $scope.getEditMode = function(movie) {
            return movie.editMode;
        };
          // function to send new account information to web api to add it to the database
        $scope.newAccount = function(accountDetails) {
          var accountupload = angular.copy(accountDetails);
          
          $http.post("newaccount.php", accountupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "index.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });
        };
        
                // function to send new account information to web api to add it to the database
        $scope.login = function(accountDetails) {
          var accountupload = angular.copy(accountDetails);
          
          $http.post("login.php", accountupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "index.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        
        // function to log the user out
        $scope.logout = function() {
          $http.post("logout.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "index.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };             
        
        // function to check if user is logged in
        $scope.checkifloggedin = function() {
          $http.post("isloggedin.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isloggedin = response.data.loggedin;
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };       
    });
    
    
} )();

