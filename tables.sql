--Create the Account Table 
DROP TABLE IF EXISTS Account;

CREATE TABLE Account(
    hawk_ID VARCHAR(120) NOT NULL,
    hashedpass VARCHAR(255) NOT NULL,
    name VARCHAR(120) NOT NULL,
    administrator BIT DEFAULT 0,
    PRIMARY KEY(hawk_ID)
);

--Insert some data into the Account Table
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("nepranger", "hawkeyes", "Nathan Pranger", 0);
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("csadmin", "hawkeyes", "Juan Pablo Hourcade", 1);
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("segre", "hawkeyes", "Alberto Segre", 0);
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("bwright", "hawkeyes", "Bob Wright", 0);


--Create the Student Table 
DROP TABLE IF EXISTS Student;

CREATE TABLE Student(
    hawk_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    budget VARCHAR(255),
    PRIMARY KEY(hawk_ID)
);

--Insert some data into the Student Table
INSERT INTO Student (hawk_ID, course_ID, budget) VALUES ("nepranger", "CS:2200", "4");

--Create the Tutor Table
DROP TABLE IF EXISTS Tutor;

CREATE TABLE Tutor(
    hawk_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    hours_per_week VARCHAR(120) NOT NULL,
    PRIMARY KEY(hawk_ID)
);

--Insert some data into the Tutor Table
INSERT INTO Tutor (hawk_ID, course_ID, hours_per_week) VALUES ("bwright", "CS:2200", "10");

--Create the Faculty Table
DROP TABLE IF EXISTS Faculty;

CREATE TABLE Faculty(
    hawk_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    PRIMARY KEY(hawk_ID)    
);

--Insert some data into the Faculty Table
INSERT INTO Faculty (hawk_ID, course_ID) VALUES ("segre", "CS:2200");

--Create the Course Table
DROP TABLE IF EXISTS Course;

CREATE TABLE Course(
    course_ID VARCHAR(120) NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    course_Number VARCHAR(120) NOT NULL,
    course_Section VARCHAR(255) NOT NULL,
    PRIMARY KEY(course_ID)
);

--Create the Problem Set Table
DROP TABLE IF EXISTS Problem_Set;

CREATE TABLE Problem_Set(
    problem_set_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    PRIMARY KEY(problem_set_ID)
);

--Create the Tutor Session Table
DROP TABLE IF EXISTS Tutor_Session;

CREATE TABLE Tutor_Session(
    session_ID VARCHAR(120) NOT NULL,
    hawk_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    cancelled_By_Tutor BIT DEFAULT 0,
    cancelled_By_Student BIT DEFAULT 0,
    session_Date VARCHAR(120) NOT NULL,
    session_Time VARCHAR(120) NOT NULL,
    rating VARCHAR(120) NOT NULL,
    PRIMARY KEY(session_ID)
);

--Create the Tutor Availability Table
DROP TABLE IF EXISTS Tutor_Availability;

CREATE TABLE Tutor_Availability(
    slot_ID VARCHAR(120) NOT NULL,
    hawk_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    available_Date VARCHAR(120),
    available_Time VARCHAR(120),
    PRIMARY KEY(slot_ID)
);
