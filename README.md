# BoyInTheBrowser

__Build a website that__:

* Allows the user to submit a putative infected file and shows if it is infected or not
* Lets a user add a surely infected file only if s/he has been authenticated as an Admin
* Ensure a secure Session mechanism


__Build a web application that__:

* Reads the file in input per bytes and, if is a surely infected one, store the sequence of bytes, say, the first 20 bytes (signature) of the file, in a database
* Reads the file in input per bytes and, if it is a putative infected file, searches within the file for one of the strings stored in the database


__Build a MySQL database that__:

* Stores the information regarding the infected files in input, such as name of the malware (not the name of the file) and the sequence of bytes
* Stores the information related to the Admin with username and password, in a secure way.


__If your group is formed by two or three people, you have to add these requirements__:

* The website will let register a user to the website as a contributor, asking for username, email and password.
* When a registered user log in on the website, s/he can upload a surely infected file and the relative signature is stored in a different table containing putative malware that must be double checked by an Admin.
* NOTE: This table is NOT the same used to upload signatures from files uploaded by an Admin. That is, it's not the table used to check if a file is infected or not.
