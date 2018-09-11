let http=require("http");
let {db_config} = require("../public/config");



function authorize(code,callback)
{
    let post_data = {"AppID":1,"code":code};
    let options = {
        host:"https://ac.ppdai.com",
        port:80,        
        path:"/oauth2/authorize",
        method:"POST",
        headers:{
            'Content-Type' : 'application/x-www-form-urlencoded',
            'Content-Length' : post_data.length
        }
    };

    let req = http.request(options,function(res){
        let data = "";
        res.on('data',function(chunk){
            data += chunk;
        });
        res.on("end",function(){
            callback(data);
        });
        res.on("error",function(e){
            if(e){
                console.info(e);
            }
        })
    });
    req.write(post_data);
    req.end();
}

exports.authorize = authorize;