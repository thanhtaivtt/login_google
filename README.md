# login_google
login google in website <br/>
create file composer.json
<pre>
<code>
{
    "require": {
      "google/apiclient": "1.0.*@beta"
    }
}

</code>
</pre>
- open cmd run code
<pre>
<code>
   composer install
</code>
</pre>
- create project on https://console.developers.google.com/apis/ <br/>
- import : <code>client_id,client_secret,client_secretmdb_username,db_password,host_name,db_name</code> <br/>
-create table usser:
<pre>
  <code>
    CREATE TABLE IF NOT EXISTS `google_users` (
  `google_id` decimal(21,0) NOT NULL,
  `google_name` varchar(60) NOT NULL,
  `google_email` varchar(60) NOT NULL,
  `google_link` varchar(60) NOT NULL,
  `google_picture_link` varchar(200) NOT NULL,
  PRIMARY KEY (`google_id`)
) ENGINE=InnoDB DEFAULT COLLATE=UTF8_GENERAL_CI;      
  </code>
</pre>
