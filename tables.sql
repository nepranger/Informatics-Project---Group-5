--Create the Account Table
DROP TABLE IF EXISTS Tutor_Session;
DROP TABLE IF EXISTS Tutor_Availability;
DROP TABLE IF EXISTS Problem_Set;
DROP TABLE IF EXISTS Faculty;
DROP TABLE IF EXISTS Tutor;
DROP TABLE IF EXISTS Student;
DROP TABLE IF EXISTS Course;
DROP TABLE IF EXISTS Account;

CREATE TABLE Account(
    hawk_ID VARCHAR(120) UNIQUE NOT NULL,
    hashedpass VARCHAR(255) NOT NULL,
    name VARCHAR(120) NOT NULL,
    administrator BIT DEFAULT 0,
    PRIMARY KEY(hawk_ID)
);

--Insert some data into the Account Table
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("nepranger", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Nathan Pranger", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("csadmin", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Juan Pablo Hourcade", 1); --Admin
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("segre", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Alberto Segre", 0); --Professor/Faculty
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("bwright", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Bob Wright", 0); --Tutor
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("dsmith", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Dan Smith", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("krenshaw", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Kallie Renshaw", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("ihoggatt", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Izola Hoggatt", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("jsanger", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Jerome Sanger", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("bmcclintock", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Bethany Mcclintock", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("fbarone", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Felice Barone", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("nbueno", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Nicolette Bueno", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("alingle", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Alina Lingle", 0); --Student
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("nreddell", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Nedra Reddell", 0); --Tutor
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("fkeas", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Felipe Keas", 0); --Tutor
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("lmendelson", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Lashell Mendelson", 0); --Tutor
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("tbaril", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Tim Baril", 0); --Tutor
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("emcafee", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Edmond Mcafee", 0); --Faculty
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("rholzman", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Richard Holzman", 0); --Faculty
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("wfleischmann", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "William Fleischmann", 0); --Faculty
INSERT INTO Account (hawk_ID, hashedpass, name, administrator) VALUES ("fbirch", "$2a$12$HId5u4IAGIpk9BgcxuGhz.EPkIc6jk.wqc/TeYWjf0NLU6W8byZwm", "Francie Birch", 0); --Faculty


CREATE TABLE Course(
    course_ID VARCHAR(120) UNIQUE NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    course_number VARCHAR(120) NOT NULL,
    course_section VARCHAR(255) NOT NULL,
    PRIMARY KEY(course_ID)
);

--Insert some data into the Course Table
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:1020", "Principles of Computing", "1020", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:1110", "Introduction to Computer Science", "1110", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:1210", "Computer Science 1: Fundamentals", "1210", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:2100", "Programming for Informatics", "2100", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:2210", "Discrete Structures", "2210", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:2520", "Human Computer Interaction", "2520", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:2620", "Networking and Security for Informatics", "2620", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:3330", "Algorithms", "3330", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:3620", "Operating Systems", "3620", "001" );
INSERT INTO Course (course_ID, course_name, course_number, course_section) VALUES ("CS:3980", "Topics in Computer Science", "3980", "001" );



--Create the Student Table 

CREATE TABLE Student(
    hawk_ID VARCHAR(120) UNIQUE NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    budget VARCHAR(255),
    PRIMARY KEY(hawk_ID, course_ID),
    FOREIGN KEY(hawk_ID) REFERENCES Account(hawk_ID),
    FOREIGN KEY (course_ID) REFERENCES Course(course_ID)
);

--Insert some data into the Student Table
INSERT INTO Student (hawk_ID, course_ID, budget) VALUES ("nepranger", "CS:1110", "4");
INSERT INTO Student (hawk_ID, course_ID, budget) VALUES ("dsmith", "CS:3980", "4");
INSERT INTO Student (hawk_ID, course_ID, budget) VALUES ("nbueno", "CS:1110", "4");

--Create the Tutor Table

CREATE TABLE Tutor(
    hawk_ID VARCHAR(120) UNIQUE NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    hours_per_week VARCHAR(120) NOT NULL,
    PRIMARY KEY(hawk_ID, course_ID),
    FOREIGN KEY(hawk_ID) REFERENCES Account(hawk_ID),
    FOREIGN KEY (course_ID) REFERENCES Course(course_ID)
);

--Insert some data into the Tutor Table
INSERT INTO Tutor (hawk_ID, course_ID, hours_per_week) VALUES ("bwright", "CS:1110", "10");
INSERT INTO Tutor (hawk_ID, course_ID, hours_per_week) VALUES ("fkeas", "CS:3980", "10");
INSERT INTO Tutor (hawk_ID, course_ID, hours_per_week) VALUES ("tbaril", "CS:3980", "10");





--Create the Faculty Table


CREATE TABLE Faculty(
    hawk_ID VARCHAR(120) UNIQUE NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    PRIMARY KEY(hawk_ID, course_ID),
    FOREIGN KEY(hawk_ID) REFERENCES Account(hawk_ID),
    FOREIGN KEY (course_ID) REFERENCES Course(course_ID)
);

--Insert some data into the Faculty Table
INSERT INTO Faculty (hawk_ID, course_ID) VALUES ("segre", "CS:1110");
INSERT INTO Faculty (hawk_ID, course_ID) VALUES ("fbirch", "CS:1110");



--Create the Problem Set Table

CREATE TABLE Problem_Set(
    problem_set_ID VARCHAR(120) UNIQUE NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    text_box VARCHAR(1000) NOT NULL, 
    PRIMARY KEY(problem_set_ID, course_ID),
    FOREIGN KEY (course_ID) REFERENCES Course(course_ID)
);

--Create the Tutor Availability Table

CREATE TABLE Tutor_Availability(
    slot_ID INT NOT NULL AUTO_INCREMENT, 
    hawk_ID VARCHAR(120) NOT NULL,
    student_hawk_ID VARCHAR(120) NOT NULL,
    available_date VARCHAR(120),
    scheduled BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(slot_ID, hawk_ID),
    FOREIGN KEY (hawk_ID) REFERENCES Tutor(hawk_ID) 
);

--Create the Tutor Session Table

CREATE TABLE Tutor_Session(
    session_ID INT NOT NULL AUTO_INCREMENT, 
    slot_ID INT NOT NULL,
    tutor_hawk_ID VARCHAR(120) NOT NULL,
    student_hawk_ID VARCHAR(120) NOT NULL,
    course_ID VARCHAR(120) NOT NULL,
    cancelled_By_Tutor BIT DEFAULT 0,
    cancelled_By_Student BIT DEFAULT 0,
    session_date VARCHAR(120) NOT NULL,
    rating VARCHAR(120) NOT NULL,
    PRIMARY KEY(session_ID, tutor_hawk_ID, course_ID),
    FOREIGN KEY (tutor_hawk_ID) REFERENCES Tutor(hawk_ID),
    FOREIGN KEY (student_hawk_ID) REFERENCES Student(hawk_ID),    
    FOREIGN KEY (course_ID) REFERENCES Course(course_ID),
    FOREIGN KEY (slot_ID) REFERENCES Tutor_Availability(slot_ID) ON DELETE CASCADE
);
