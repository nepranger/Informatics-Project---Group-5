--Create the Account Table 
DROP TABLE IF EXISTS Account;

CREATE TABLE Account(
    Hawk_ID VARCHAR(120) NOT NULL,
    Hashedpass VARCHAR(255) NOT NULL,
    Name VARCHAR(120) NOT NULL,
    Administrator BIT DEFAULT 0,
    PRIMARY KEY(Hawk_ID)
);

--Insert some data into the Account Table
INSERT INTO Account (Hawk_ID, Hashedpass, Name, Administrator) VALUES ("nepranger", "hawkeyes", "Nathan Pranger", 0);
INSERT INTO Account (Hawk_ID, Hashedpass, Name, Administrator) VALUES ("csadmin", "hawkeyes", "Juan Pablo Hourcade", 1);
INSERT INTO Account (Hawk_ID, Hashedpass, Name, Administrator) VALUES ("segre", "hawkeyes", "Alberto Segre", 0);
INSERT INTO Account (Hawk_ID, Hashedpass, Name, Administrator) VALUES ("bwright", "hawkeyes", "Bob Wright", 0);


--Create the Student Table 
DROP TABLE IF EXISTS Student;

CREATE TABLE Student(
    Hawk_ID VARCHAR(120) NOT NULL,
    Course_ID VARCHAR(120) NOT NULL,
    Budget VARCHAR(255),
    PRIMARY KEY(Hawk_ID)
);

--Insert some data into the Student Table
INSERT INTO Student (Hawk_ID, Course_ID, Budget) VALUES ("nepranger", "CS:2200", "4");

--Create the Tutor Table
DROP TABLE IF EXISTS Tutor;

CREATE TABLE Tutor(
    Hawk_ID VARCHAR(120) NOT NULL,
    Course_ID VARCHAR(120) NOT NULL,
    Hours_Per_Week VARCHAR(120) NOT NULL,
    PRIMARY KEY(Hawk_ID)
);

--Insert some data into the Tutor Table
INSERT INTO Tutor (Hawk_ID, Course_ID, Hours_Per_Week) VALUES ("bwright", "CS:2200", "10");

--Create the Faculty Table
DROP TABLE IF EXISTS Faculty;

CREATE TABLE Faculty(
    Hawk_ID VARCHAR(120) NOT NULL,
    Course_ID VARCHAR(120) NOT NULL,
    PRIMARY KEY(Hawk_ID)    
);

--Insert some data into the Faculty Table
INSERT INTO Faculty (Hawk_ID, Course_ID) VALUES ("segre", "CS:2200");

--Create the Course Table
DROP TABLE IF EXISTS Course;

CREATE TABLE Course(
    Course_ID VARCHAR(120) NOT NULL,
    Course_Name VARCHAR(255) NOT NULL,
    Course_Number VARCHAR(120) NOT NULL,
    Course_Section VARCHAR(255) NOT NULL,
    PRIMARY KEY(Course_ID)
);

--Create the Problem Set Table
DROP TABLE IF EXISTS Problem_Set;

CREATE TABLE Problem_Set(
    Problem_Set_ID VARCHAR(120) NOT NULL,
    Course_ID VARCHAR(120) NOT NULL,
    PRIMARY KEY(Problem_Set_ID)
);

--Create the Tutor Session Table
DROP TABLE IF EXISTS Tutor_Session;

CREATE TABLE Tutor_Session(
    Session_ID VARCHAR(120) NOT NULL,
    Hawk_ID VARCHAR(120) NOT NULL,
    Course_ID VARCHAR(120) NOT NULL,
    Cancelled_By_Tutor BIT DEFAULT 0,
    Cancelled_By_Student BIT DEFAULT 0,
    Session_Date VARCHAR(120) NOT NULL,
    Session_Time VARCHAR(120) NOT NULL,
    Rating VARCHAR(120) NOT NULL,
    PRIMARY KEY(Session_ID)
);

--Create the Tutor Availability Table
DROP TABLE IF EXISTS Tutor_Availability;

CREATE TABLE Tutor_Availability(
    Slot_ID VARCHAR(120) NOT NULL,
    Hawk_ID VARCHAR(120) NOT NULL,
    Course_ID VARCHAR(120) NOT NULL,
    Available_Date VARCHAR(120),
    Available_Time VARCHAR(120),
    PRIMARY KEY(Slot_ID)
);
