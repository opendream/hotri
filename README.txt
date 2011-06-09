ความต้องการเบื้องต้น
- PHP รุ่น 5.1 ขึ้นไป
-- php5-mysql
-- php5-gd
-- php5-curl
- MySQL รุ่น 5 ขึ้นไป
- ในกรณีที่ต้องการใช้งานการค้นหาออนไลน์/การค้นหา ISBN จำเป็นจะต้องมี
  * YAZ รุ่น 3.0.52 ขึ้นไ
  * crontab หรือโปรแกรมที่เทียบเท่า
- ในกรณีที่ต้องการใช้งานการค้นหาปกห้องสือจาก Amazon จะเป็นจะต้องมี
  * AWS Key
  * AWS Secret Key
  * AWS Account ID
ข้อมูลทั้งสามส่วนสามารถรับได้ที่ Amazon Web Service http://aws.amazon.com หากมีบัญชีผู้ใช้ Amazon แล้วสามารถเข้าไปดูค่าเหล่านี้ได้จากใน 'Personal Information'

Prerequisite:
- PHP 5.1 and up. (PHP 5.3 is now supported)
-- php5-mysql
-- php5-gd
-- php5-curl
- MySQL 5 and up.
- For online search / ISBN lookup, they require: 
  * YAZ library 3.0.52 (setup instructions in [base_directory]/prerequisites/yaz-3.0.52/README)
    Hint: for more comfortable instructions, check 'Create a School Library Catalog For Cheap' article on e-frank.com, 
    http://www.e-frank.com/2008/03/16/create-a-school-library-catalog-for-cheap
  * crontab or same things for execute cron jobs. (crontab is available on unix-based operating system)

- For online book cover lookup, Amazon AWS account is required.
  * AWS Key
  * AWS Secret Key
  * AWS Account ID

For more information and create new account, please visit http://aws.amazon.com/
Hint: Check 'Personal Information' to get keys & account ID.

Setup Instructions:
- Create / setup database for openbiblio, specific collation to 'utf8_general_ci'.
- Extract & copy all hotri directory to public website directory.
- For unix-based operating system, set directories/files permission as below:
  * chmod 777 for [base_directory]/media
  * chmod 666 for [base_directory]/cron/cronrun.txt

- Edit 'database_constant.php' file to setup database connection.
- Open the web browser and go to hotri like http://yourdomain.com/hotri
- When this is your first setup, install page would be appeared, otherwise it should be show you homepage.
- For fresh install, select locale, optional install test data, then click install button (like original openbiblio).
- Done.

Note: 
- For import book/biblio data from CSV, use 'Cataloging > CSV Import' and follow instruction guidelines in this page and so on.
- For online search, you could configure servers for lookup on 'Admin > Z39.50 Servers'.
- For online book cover lookup, configure on 'Admin > Cover Lookup Options'.

Known issues:
- Book cover lookup service doesn't work on PHP4 because of class & object issues.
