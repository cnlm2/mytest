var express = require('express');
var router = express.Router();
var usr=require('../accountdb/user');
var auth=require('../accountdb/auth');
var bid=require('../accountdb/bid');
var url=require("url");

/* GET home page. */
router.get('/', function(req, res) {
    if(req.cookies.islogin){
        req.session.islogin=req.cookies.islogin;
    }
    if(req.session.islogin){
        res.locals.islogin=req.session.islogin;
    }
    if (res.locals.islogin) {
        res.redirect("/home");
    } else {
        res.redirect("/login")
    }
    //res.render('index', { title: 'HOME',test:res.locals.islogin});
});


router.route('/login')
    .get(function(req, res) {
        if(req.session.islogin){
            res.locals.islogin=req.session.islogin;
        }

        if(req.cookies.islogin){
            req.session.islogin=req.cookies.islogin;
        }
        res.render('login', { title: '用户登录' ,test:res.locals.islogin});
    })
    .post(async function(req, res) {
        let ret = await usr.AuthUser(req.body.username, req.body.password);
        console.log("login");
        if (ret) {
            req.session.islogin=req.body.username;
            res.locals.islogin=req.session.islogin;
            res.cookie('islogin',res.locals.islogin,{maxAge:60000});
            res.send(200);
        } else {
            req.session.error = "密码错误";
            res.send(404);
        }
    });

router.get('/logout', function(req, res) {
    res.clearCookie('islogin');
    req.session.destroy();
    res.redirect('/');
});

router.get('/home', async function(req, res) {
    if(req.session.islogin){
        res.locals.islogin=req.session.islogin;
    }
    if(req.cookies.islogin){
        req.session.islogin=req.cookies.islogin;
    }
    account = res.locals.islogin;
    bid_today = await bid.getBidToday(account);
    bid_yestoday = await bid.getBidYestoday(account);
    bid_total = await bid.getBidTotal(account);
    user = await usr.FindUser(account);
    authInfo = await auth.getAll(account);

    console.log("home",bid_today);
    console.log("home",bid_yestoday);
    console.log("home",bid_total);
    console.log("home",user);
    console.log("home",authInfo);
    res.render('home', { title: '主页', 
        user: user, 
        bid_today:bid_today,
        bid_yestoday:bid_yestoday,
        bid_total:bid_total,
        authInfo:authInfo, 
    });
});

router.route('/reg')
    .get(function(req,res){
        res.render('reg',{title:'用户注册'});
    })
    .post(async function(req,res) {
        let ret = await usr.AddUser(req.body.username ,req.body.password);
        if (ret) {
            req.session.islogin=req.body.username;
            res.locals.islogin=req.session.islogin;
            res.cookie('islogin',res.locals.islogin,{maxAge:60000});
            res.send(200);
            
        } else {
            req.session.error = "密码错误";
            res.send(404);
        }
    });

router.route('/auth')
    .get(function(req,res){
        let params = url.parse(req.url,true).query;
        res.send(params.code);
    })
    .post(function() {
        
    });

module.exports = router;

