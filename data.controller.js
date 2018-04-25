/*
 *Controller where we get the data on the movies
 */
(function() {
    'use strict';
    
    var myApp = angular.module("project");
    myApp.controller("dataControl",function($scope, $http, $window) {
        
        
       $scope.query = {};
       $scope.queryBy = "$";
       
       //this variable will hold the page number that should be highleted in the menu bar
       //0 is home.
       $scope.menuHighlight = 0;
       
       
       /*
        * Set the edit mode of a particular player
        * on is true if we are setting edit mode to be on, false otherwise
        * movie corresponds to the movie to which we are setting an edit mode
        */
       $scope.setEditMode = function(on, movie){
        if(on){
            //movie.reldate = parseInt(movie.reldate); 
            $scope.editmovie = angular.copy(movie); 
            movie.editMode = true; 
        } else {
            $scope.editmovie = null;
            movie.editMode = false;
        }
       };
       
       /*
        *Gets the edit mode for a particular movie
        */
        $scope.getEditMode = function(movie){
            return movie.editMode;

       };
       
    //some else if statements to handle different types of accounts
    //function to send new account information to web api to add it to the database
       $scope.login = function(accountDetails) {
        var accountupload = angular.copy(accountDetails);
        
        $http.post("login.php", accountupload)
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        if (response.data.isstudent) {
                            $window.location.href = "StudentHome.html";
                        } else if (response.data.istutor) {
                            $window.location.href = "TutorHome.html";
                        } else if (response.data.isfaculty) {
                            $window.location.href = "FacultyHome.html";
                        } else if (response.data.isadmin) {
                            $window.location.href = "AdminHome.html";
                        }
                        //$window.location.href = "home.html";
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
            
            
        
       };
       
     //function to log the user out
       $scope.logout = function() {
        
        $http.post("logout.php")
            .then(function(response) {
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
       $scope.checkifloggedin = function() {
        
        $http.post("isloggedin.php")
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        //set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isloggedin = response.data.loggedin;
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
            
            
        
       };
       
       
       
       
       

    });
    
})();
