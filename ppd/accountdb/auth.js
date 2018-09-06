
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


exports.getAll = getAll;