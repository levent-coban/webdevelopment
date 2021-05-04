# PHP & MySQL

The implementation of PHP & MySQL includes two part.


### Section A

Backend functionality was created for an e-mail subscription based on HTML & CSS page.

    - Submitted data can be saved in a MySQL database. 
    - Success message appears after form submit.
    - Data is validated in PHP and if JavaScript is disabled it displays errors in the same place 
      and style as it is with JavaScript enabled.


### Section B

All saved data can be seen at: `http://localhost/subscribers`

    - No styles are applied for these page. PHP codes have been implemented, practice and functionality is aimed. 
    - Sorting by name and date is added (by default it sorts data by date)

    - It is possible to filter email addresses by email providers:
            For Instance: If under subscriptions there are 3 Gmail, 5 Yahoo and 2 Outlook email
            addresses, 3 buttons appear: Gmail, Yahoo and Outlook. Once new subscriptions 
            from a different provider appear, for instance HubSpot, this leads to the automatic 
            appearance of a new button which will allow to filter out all the email addresses 
            with the email provider that not from HubSpot.
            
    - Deletion option has been added for e-mail addresses. 
    - Pagination is present on the list with 10 records (emails) per page.
    - It is possible to search for email addresses and use filters and sorting at the same time.
    - It is possible to select multiple emails using checkboxes and export them as CSV.



# Installation about PHP & MySQL

Note: 
To be rapid on implementation, Section B was separated than Section A.
Remove the Section A files from root directory when you check the Section B.

Place all the files from SECTION into server's root directory.

    - Run `db.sql` file. 
    - It creates database named 'subscriptiondb' a table named 'subscribers' and dumps the sample data into the table.
    - Set host name, user name and password for database within that directory: `/database/dbconfig.php`
    - You can visit `http://localhost`, `http://localhost/subscribers`, http://localhost/search