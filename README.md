# Data Management Information System

## Tech Stack
HTML, CSS, JavaScript, PHP, MySQL

Start Bootstrap - SB Admin 2 v4.1.3  
(https://startbootstrap.com/theme/sb-admin-2)  
Bootstrap v4.6.0  
(https://getbootstrap.com/)  
Font Awesome Free 5.15.3  
(https://fontawesome.com)  
jQuery JavaScript Library v3.6.0  
(https://jquery.com/)  
jQuery Easing v1.4.1  
(http://gsgd.co.uk/sandbox/jquery/easing/)  
DataTables 1.10.24  
(https://datatables.net)  
Chart.js v2.9.4  
(https://www.chartjs.org)  
  
## Naming Conventions  
HTML - lowercase with hyphen in double qoutes properties  
ex: <code>id="site-header"</code>, <code>name="update-changes"</code>  
CSS - lowercase with hyphen  
ex: <code>#site-header</code>, <code>.active-link</code>  
JavaScript - camelcase variable and function names  
ex: <code>var eyeToggle</code>, <code>function generateRandomColor(num) {}</code>  
PHP - snakecase for variables and camelcase for function names  
ex: <code>&dollar;success = ''</code>, <code>function toLongDateString($date) {}</code>  
Database Column Names - snake case  
ex: <code>last_name</code>, <code>first_name</code>, <code>middle_name</code>  
  
Formatting: use single qoute for string literals and array keys

###### ----------------------------------------------------------------------------------------------------------------------------------

## Features

#### Authentication
<ul>
    <li>Login</li>
    <li>Forgot Password</li>
    <li>Change Password</li>
    <li>Logout</li>
</ul>

#### Activity Log (View Only)

#### Edit History (View Only)

#### Settings
<ul>
    <li>Profile Photo (Can Update)</li>
    <li>Contact Details (Can Update)</li>
    <li>Professional Title (Can Update)</li>
    <li>Password Change (Can Update)</li>
</ul>

#### Notifications

#### Employee Information Status Percentage

###### ----------------------------------------------------------------------------------------------------------------------------------

### PERSONNEL INFORMATION SYSTEM

#### Employee Information (Own Only)
<ul>
    <li>Personal Information (View Only)</li>
    <li>Family Background (View Only)</li>
    <li>Children (View Only)</li>
    <li>Educational Background (View Only)</li>
    <li>Civil Service Eligibility (View Only)</li>
    <li>Work Experience (View Only)</li>
    <li>Voluntary Work (View Only)</li>
    <li>Learning &amp; Development (View Only)</li>
    <li>Special Skills &amp; Hobbies (View Only)</li>
    <li>Non-Academic Distinctions / Recognition (View Only)</li>
    <li>Membership in Association / Organization (View Only)</li>
    <li>Other Information (View Only)</li>
    <li>References (View Only)</li>
    <li>Government Issued ID (Can Update)</li>
</ul>

#### Service Record (View Own Only)

#### 201 Files (View & Download Own Only)

#### Trainings (Own Only)
<ul>
    <li>View &amp; Download Certificate of Participation (If Available)</li>
    <li>View &amp; Download Certificate of Appearance (If Available)</li>
</ul>

#### Payslip (Own Only)
<ul>
    <li>Payslip (Add, Update, Delete, Preview, Download)</li>
</ul>

###### ----------------------------------------------------------------------------------------------------------------------------------

### DOCUMENT TRACKING SYSTEM

#### Create New Document w/ File Attachment</li>

#### View Documents
<ul>
    <li>Incoming Documents (Document to be received by station)</li>
    <li>Pending Documents (Document received by station and waiting for action)</li>
    <li>Outgoing Documents (Document forwarded by station to another station)</li>
    <li>Ongoing Documents (Document from station that are not yet completed or canceled)</li>
    <li>Completed Documents (Document marked completed by station where it was last received)</li>
    <li>Canceled Documents (Document marked canceled by station where it was created)</li>
</ul>

#### View Document Information

#### Print Document Tracking Slip (Document station origin)

#### Receive Document (Incoming Document)

#### Forward Document (Pending Document) w/ File Attachment

#### Mark Completed Document (Pending Documents)

#### Edit Document
<ul>
    <li>Outgoing Document (For Creator station/starting point) 
        <ul>
            <li>Edit Document Type</li>
            <li>Edit Description</li>
            <li>Edit Destination</li>
            <li>Edit Purpose</li>
            <li>Edit Additional details</li>
            <li>Edit Attachment</li>
        </ul>
    </li>
    <li>Outgoing Document (Non-creator and forwarding station for ongoing document)
        <ul>
            <li>Edit Destination</li>
            <li>Edit Purpose</li>
            <li>Edit Additional details</li>
            <li>Edit Attachment</li>
        </ul>
    </li>
</ul>

#### Cancel Document (Outgoing document of creator station)

#### Export Document Transaction Logs

#### View Section/School Users Summary
<ul>
    <li>Created Documents</li>
    <li>Received Documents</li>
    <li>Forwarded Documents (Sections only)</li>
    <li>Completed Documents</li>
    <li>Canceled Documents</li>
</ul>

##### ----------------------------------------------------------------------------------------------------------------------------------

### Human Resource Management Information System

#### Add Employee

#### View Employees
<ul>
    <li>Active Employees</li>
    <li>Retirable Employees</li>
    <li>Celebrant Employees</li>
    <li>Archived Employees</li>
    <li>Employees for Step Increments</li>
    <li>Employees for Loyalty Award</li>
</ul>

#### Reassign Employee (Personnel Section Users Only)

#### Promote Employee (Personnel Section Users Only)

#### Remove Employee (Personnel Section Users Only)

#### Approve Step Increment (Personnel Section Users Only)

#### Approve Loyalty Award (Personnel Section Users Only)

#### Vacancies (Personnel Section Users Only) 
<ul>
    <li>Create Vacancies
        <ul>
            <li>New Item</li>
            <li>Vacated Item through Removal of Employee</li>
        </ul>
    </li>
    <li>Edit Vacancies</li>
    <li>Delete Vacancy</li>
</ul>

#### Dashboard Charts
<ul>
    <li>Employees By Gender</li>
    <li>Employee Categories By Gender</li>
    <li>Employees By Category</li>
    <li>Employees By Position</li>
    <li>Employees By District</li>
    <li>Employees By Assignment</li>
</ul>

#### Employee Information (Update Anyone)
<ul>
    <li>Personal Information (Can Update)</li>
    <li>Family Background (Can Update)</li>
    <li>Children (Can Add, Update, Delete)</li>
    <li>Educational Background (Can Add, Update, Delete)</li>
    <li>Civil Service Eligibility (Can Add, Update, Delete)</li>
    <li>Work Experience (Can Add, Update, Delete)</li>
    <li>Voluntary Work (Can Add, Update, Delete)</li>
    <li>Learning &amp; Development (View Only)</li>
    <li>Special Skills &amp; Hobbies (Can Add, Update, Delete)</li>
    <li>Non-Academic Distinctions / Recognition (Can Add, Update, Delete)</li>
    <li>Membership in Association / Organization (Can Add, Update, Delete)</li>
    <li>Other Information (Can Update)</li>
    <li>References (Can Add, Update, Delete)</li>
    <li>Government Issued ID (View Only)</li>
</ul>

#### Service Record (Update Anyone)
<ul>
    <li>Service Record (Can Add, Update, Delete)</li>
    <li>Print Service Record</li>
</ul>

#### 201 Files (Update &amp; Download Anyone)

#### Trainings (View Anyone Only)
<ul>
    <li>Download Certificate of Participation (If Available)</li>
    <li>Download Certificate of Appearance (If Available)</li>
</ul>

#### PSIPOP (Update Anyone)

#### Edit History (View Only)

##### ----------------------------------------------------------------------------------------------------------------------------------

### HUMAN RESOURCE TRAINING &amp; DEVELOPMENT MANAGEMENT SYSTEM

#### Division Training Certificate Finder
<ul>
    <li>View Training Details</li>
    <li>Download Certificates (If Available)</li>
</ul>

#### Dashboard Charts
<ul>
    <li>Conducted Trainings</li>
    <li>Trained Employees</li>
</ul>

#### Add Training

#### View Trainings
<ul>
    <li>Scheduled Trainings</li>
    <li>Conducted Trainings</li>
</ul>

#### Edit Trainings

#### Add Training Participants (Conducted Trainings)

#### View Employees

#### View Districts

#### View Schools

#### View Sections

##### ----------------------------------------------------------------------------------------------------------------------------------

### DIVISION MANAGEMENT INFORMATION SYSTEM

#### View Employees

#### Districts (View, Add, Delete, Update, Export)

#### Schools (View, Add, Delete, Update, Export)

#### Sections (View, Add, Delete, Update, Export)

#### Users (View, Assign, Update, Reset Password, Remove, Export)

#### Transactions  (View Only)
<ul>
    <li>Schools</li>
    <li>Sections</li>
</ul>

#### System Log (View Only)