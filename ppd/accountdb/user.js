
let accountdb = require("./accountdb");


async function FindUser(account) 
{
    console.log("FindUser",account);
    let sql = "select * from accounts where account=? ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account]);
    if ( rows.length > 0 ) {
        return rows[0];
    }
    return false;
}

async function AddUser(account, pw)
{
    console.log("AddUser",account,pw);
    if (await FindUser(account)) {
        return false;
    }
    let sql = "insert into accounts (account,password,total_rechange,balance,plateform) values(?,?,0,0,'www')";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account,pw]);
    return rows.affectedRows > 0;  
}

async function AuthUser(account,pw)
{
    console.log("FindUser",account,pw);
    let sql = "select * from accounts where account=? and password=?";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account,pw]);
    return rows.length > 0
}

exports.FindUser = FindUser;
exports.AddUser  = AddUser;
exports.AuthUser = AuthUser;