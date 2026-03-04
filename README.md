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
PHP - camelcase variable and function names  
ex: <code>&dollar;success = ''</code>, <code>function toLongDateString($date) {}</code>  
Database Column Names - snake case  
ex: <code>last_name</code>, <code>first_name</code>, <code>middle_name</code>  
  
Formatting: use single qoute for string literals and array keys

## Features
<ul>
    <li>Authentication
        <ul>
            <li>Login</li>
            <li>Forgot Password</li>
            <li>Change Password</li>
            <li>Logout</li>
        </ul>
    </li>
    <li>Activity Log (View Only)</li>
    <li>Edit History (View Only)</li>
    <li>Settings
        <ul>
            <li>Profile Photo (Can Update)</li>
            <li>Contact Details (Can Update)</li>
            <li>Professional Title (Can Update)</li>
            <li>Password Change (Can Update)</li>
        </ul>
    </li>
    <li>Personnel Information System
        <ul>
            <li>Employee Information (Update Own Only)
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
            </li>
            <li>Service Record (View Own Only)</li>
            <li>201 Files (View Own Only)
                <ul>
                    <li>201 Files (Preview and Download)</li>
                </ul>
            </li>
            <li>Trainings (View Own Only)
                <ul>
                    <li>Download Certificate of Participation (If Available)</li>
                    <li>Download Certificate of Appearance (If Available)</li>
                </ul>
            </li>
            <li>Payslip (Update Own Only)
                <ul>
                    <li>Payslip (Add, Update, Delete, Preview, Download)</li>
                </ul>
            </li>
        </ul>
    </li>
    <li>Human Resource Management Information System
        <ul>
            <li>Add Employee</li>
            <li>View Employees
                <ul>
                    <li>Active Employees</li>
                    <li>Retirable Employees</li>
                    <li>Celebrant Employees</li>
                    <li>Archived Employees</li>
                    <li>Employees for Step Increments</li>
                    <li>Employees for Loyalty Award</li>
                </ul>
            </li>
            <li>Reassign Employee (Personnel Section Users Only)</li>
            <li>Promote Employee (Personnel Section Users Only)</li>
            <li>Remove Employee (Personnel Section Users Only)</li>
            <li>Approve Step Increment (Personnel Section Users Only)</li>
            <li>Approve Loyalty Award (Personnel Section Users Only)</li>
            <li>Vacancies (Personnel Section Users Only) 
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
            </li>
            <li>Dashboard Charts
                <ul>
                    <li>Employees By Gender</li>
                    <li>Employee Categories By Gender</li>
                    <li>Employees By Category</li>
                    <li>Employees By Position</li>
                    <li>Employees By District</li>
                    <li>Employees By Assignment</li>
                    <li></li>
                </ul>
            </li>

            <li>Employee Information (Update Anyone)
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
            </li>
            <li>Service Record (Update Anyone)
                <ul>
                    <li>Service Record (Can Add, Update, Delete)</li>
                    <li>Print Service Record</li>
                </ul>
            </li>
            <li>201 Files (Update Anyone)
                <ul>
                    <li>201 Files (Can Add, Update, Delete, Preview and Download)</li>
                </ul>
            </li>
            <li>Trainings (View Anyone Only)
                <ul>
                    <li>Download Certificate of Participation (If Available)</li>
                    <li>Download Certificate of Appearance (If Available)</li>
                </ul>
            </li>
            <li>PSIPOP (Update Anyone)</li>
            <li>Edit History (View Only)</li>
        </ul>
    </li>
    <li>Document Tracking System
        <ul>
            <li>Search Document (https://website.com/dts/track)</li>
        </ul>
    </li>
    <li>Human Resource Training &amp; Development Management System
        <ul>
            <li>Division Training Certificate Finder (https://website.com/hrtdms/repository)</li>
        </ul>
    </li>
</ul>