
let mysql = require ('mysql2/promise');
let {db_config} = require("../public/config");


let pool = mysql.createPool({
  connectionLimit: 20,
  host     : db_config.auth_mysql_host,
  user     : db_config.auth_server_user,
  password : db_config.auth_server_pw,
  database : db_config.auth_server_db,
});

exports.pool = pool;