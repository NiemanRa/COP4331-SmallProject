<?php

/*  Search sql query
*   
*   $sql = "
*   SELECT id, user_id, first_name, last_name, email, personal_phone, work_phone, date_created
*   FROM contacts
*   WHERE user_id = ? AND (first_name LIKE ? OR last_name LIKE ?)
*   ORDER BY first_name, last_name;
*    ";
*/ 