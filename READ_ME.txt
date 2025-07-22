
Main Pages =>
-------------

1. Login.php
2. Signup.php
3. logout.php
3. ho_dashboard.php

Global Pages =>
---------------

1. header.php
2. footer.php
3. menu_ho

These 3 are included in each php page where applicable.


Dashboard =>
------------

1. First Login as role type 'HO' user to access the Dashboard
2. Go to Menu: Head Office -> Employee Info.
                              (Pages used here: employee_list.php, add_employee.php,edit_employee.php,
                                                delete_employee.php, get_units.php
                              )

3. Header of Dashboard: About, Services, contact (link page is there for each)


Users =>
--------

      1. Email: salahuddin2017111203@gmail.com, password: _Salmoon1234
         Role: IT Admin
         Role Type: HO
         Menu: Only Allowed for this Role.

      2. Email: salahuddin081402@gmail.com, password: 1234
         Role: Super Admin
         Role Type: HO
         Menu: Only Allowed for this Role.



Database Hierarchy =>
---------------------

# Location:-
-------------

division      
   |             
district     
   |            
upazila    
   |                                         
union_tbl                                    
   |                                         
village                                  


# Role Setup:-
--------------
role_type
  |
role
  |  
role_menu


# Head office:-
----------------
department     
   |           
 Unit     
   |             
Employee_Info                               







Note: During Signup 'Role' must be selected as business requirement of head office

