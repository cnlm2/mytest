
let accountdb = require("./accountdb");


async function getAll(account) 
{
    console.log("getAll",account);
    let sql = "select * from auth where account=? ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account]);
    if ( rows.length > 0 ) {
        return rows;
    }
    return false;
}

async function FindUser(account) 
{
    console.log("FindUser",account);
    let sql = "select * from auth where ppd_account=? ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account]);
    if ( rows.length > 0 ) {
        return rows[0];
    }
    return false;
}

async function AddUser(account,ppd_account,openid,access_token,refresh_token)
{
    console.log("authUser",account,ppd_account,access_token,openid,refresh_token);
    if (await FindUser(ppd_account)) {
        return false;
    }
    let sql = "insert into accounts (account,ppd_account,openid,access_token,refresh_token,status) values(?,?,?,?,?,0)";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account,ppd_account,openid,access_token,refresh_token]);
    return rows.affectedRows > 0;  
}

exports.getAll = getAll;
exports.AddUser = AddUser;