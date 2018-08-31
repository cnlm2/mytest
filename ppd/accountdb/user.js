
let accountdb = require("./accountdb");


async function FindUser(account) 
{
    console.log("FindUser",account);
    let sql = "select * from accounts where name=? ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account])
    if ( rows.length > 0 ) {
        return fields;
    }
}

async function AddUser(account, pw)
{
    console.log("AddUser",account,pw);
    if (FindUser(account)) {
        return false;
    }
    let sql = "insert into accounts values(?,?,'lianpeng')";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account,pw])
    return rows.length > 0;  
}

async function AuthUser(account,pw)
{
    console.log("FindUser",account,pw);
    let sql = "select * from accounts where name=? and password=?";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account,pw]);
    return rows.length > 0
}

exports.FindUser = FindUser;
exports.AddUser  = AddUser;
exports.AuthUser = AuthUser;