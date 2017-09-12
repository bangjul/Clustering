How can you read and display excel file using php and save that details to the database? You can use this simple php class to do this.That is read row by row while reading column by column.While reading like this it gets each cells details.Look at this example that is simply describes this process and you can understand this better.

First download excel reader.php class file.
Also you must include this oleread.inc file of this reader.php file.

How to read excel file using php?
read-excel-file.php

Note:
This is reading sheet1 details. If you want to read sheet 2 details, then change the sheets[0] to sheets[1] in both while loops.

Example:
while($x<=$excel->sheets[0]['numRows']) {

Remember “sheets” is the array.Array begin from 0.You already know about it. :D
So,
Sheet1 -> sheets[0]
Sheet2 -> sheets[1]
Sheet3 -> sheets[2]

How to read and save details to the database using php?
sheet1.sql
sheet2.sql
save-details-to-database.php

---
Source:

http://webexplorar.com/read-excel-file-and-save-details-to-database-using-php/