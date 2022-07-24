# IS for reporting public nuisance

The implementation of an information system for reporting public nuisance using CodeIgniter

##  Functionalities

### Static pages

My website has three of them: Home, About and Forbidden pages. These are the pages that are not dynamic, so they are static, which means that their content does not change whatever you do (does not apply for header).

### Log In / Sign Up

When you sing up (register), you fill in your details like name, username, password, etc. When doing this, server would check whether your username and email are unique, and whether your password fields match. After the registration, you may log in. Keep in mind that the registration form given on the website can give you Citizen role only (there are Citizen, Authorities and Moderator roles in total).

Keep in mind that all the passwords are safely protected. This is achieved with a password-hashing function bcrypt. 

###	(Citizen role) Create Report

Your fill in the title, category and statement fields, after which the report is stored in the database and can be accessed in Reports section even if you are not logged in.

### (Authorities role) Answer the Report/Appeal/Addition

When authorities want to answer the report/appeal/addition, they click on the corresponding button and fill in the decision (approved/not approved) and explanation of their decision.

Keep in mind that authorities can only answer when the last “message” was from the Citizen. This means that Authorities cannot publish answer when they were the last one who sent the answer.

### (Citizen role) Appeal (or provide additional information) to the report

When citizen has received the answer from the authorities, he can appeal it or provide additional information.

Keep in mind that Citizen can only appeal when the last message regarding some report was send from the authorities (because it is not some web chat or something, it is an official channel of communication).

### (Citizen role) Send Edit request

Citizen can send an edit request to change his report or some appeal text. He cannot do this directly because it is an official channel of communication between the citizen and the government representative, which means that when information is changes, it cannot lose the main plot of the message. That is why such restriction was made, so that somebody else (Moderator role) could check them and approve or disapprove changes.

### (Moderator role) Approve/disapprove Edit request

When citizen sends a request to edit his report/appeal, the Moderator’s goal is to identify whether the main message of this particular report/appeal will still hold after the editing so that this functionality not abused by citizens with bad intentions. The moderator either approves or disapproves changes depending on his personal decision.

### (Citizen role) Send Delete Request and (Authorities role) Approve/Disapprove Delete Request

If user decides to delete his whole report, he can do this only with approval from authorities’ side. Again, this is done due to being an official communication channel, so this is required here.

### Restricted access for different roles

What I did is I disabled the option of doing some things that some particular user would want to do, although he would not have enough permissions for this. This is done on TWO (!) sides: on the client side (view) and on the server side (controller). What is on the page of some user (view) is only those things that his role allow him to do. But even if the user knows how to do something that he has not enough rights to do, the controller also checks it and will not allow you to do something that you have no permission to do. So, it’s sort of double protection.

In addition, only the original author of some report can appeal to the answer regarding to it and nobody else except from him can do this, but this should be obvious, and still it is a restricted access.

### Profile page

Whatever you do, whenever you see some name (even yours in the navbar), you can click it and you will be redirected to the profile page of this user. This is done in case you are interested in his email, how long he is on this website, all his roles or something else (but username and password, of course, are not here, since they are required for log in, so that no one else knows them).

### Other stuff

- Not that important, but citizen has an option to see only those reports that he has created and authorities can see only those reports where he has participated in.

- Also, I have made flash messages. They are displayed when you do some manipulations with the database or when you are logged in or logged out OR when you do not fill some field, so all the fields should always be filled. Some of them are a bit custom so that the overall webpage would look nice.

- Although this is not a functionality, I think this deserves mentioning. I tried to make as much comfortable CSS design using Bootstrap (Bootswatch theme Quartz) as it can only be, and I think that this goal was achieved.

### How to test it

Username and password details for different roles (if you wish to test the system by yourself):

| Username | Password | Role(s) |
| --- | --- | --- |
| donald | maga2020! | Citizen |
| bill | microsoft | Authorities |
| elon | tesla | Moderator |
| napoleon | france | Citizen, Authorities, Moderator (all of them) |

