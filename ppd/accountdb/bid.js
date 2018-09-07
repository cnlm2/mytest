
let accountdb = require("./accountdb");


async function getBidTotal(account) 
{
    console.log("FindUser",account);
    let sql = "select COALESCE(sum(bid_amount),0) as amount from bid where account=? ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account]);
    if ( rows.length > 0 ) {
        return rows[0];
    }
    return 0;
}
async function getBidToday(account) 
{
    console.log("FindUser",account);
    let sql = "select COALESCE(sum(bid_amount),0) as amount, count(DISTINCT id) as times from bid where account=? and to_days(time)=to_days(now()) ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account]);
    if ( rows.length > 0 ) {
        return rows[0];
    }
    return false;
}

async function getBidYestoday(account) 
{
    console.log("FindUser",account);
    let sql = "select COALESCE(sum(bid_amount),0) as amount, count(DISTINCT id) as times from bid where account=? and to_days(time)=to_days(now())-1 ";
    let rows;
    let fields;
    [rows,fields] = await accountdb.pool.query(sql, [account]);
    if ( rows.length > 0 ) {
        return rows[0];
    }
    return false;
}


exports.getBidTotal = getBidTotal;
exports.getBidToday  = getBidToday;
exports.getBidYestoday = getBidYestoday;