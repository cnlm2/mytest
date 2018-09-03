var express = require('express');
var router = express.Router();
var usr=require('../accountdb/user');

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

router.get('/home', function(req, res) {
    if(req.session.islogin){
        res.locals.islogin=req.session.islogin;
    }
    if(req.cookies.islogin){
        req.session.islogin=req.cookies.islogin;
    }
    res.render('home', { title: '主页', user: res.locals.islogin });
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

module.exports = router;

