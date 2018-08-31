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
  res.render('index', { title: 'HOME',test:res.locals.islogin});
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
    .post(function(req, res) {
        if (usr.AuthUser(req.body.username, req.body.password)) {
            req.session.islogin=req.body.username;
            res.locals.islogin=req.session.islogin;
            res.cookie('islogin',res.locals.islogin,{maxAge:60000});
            res.redirect('/home');
        } else {
            res.send('用户名或密码错误！');
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
    res.render('home', { title: 'Home', user: res.locals.islogin });
});

router.route('/reg')
    .get(function(req,res){
        res.render('reg',{title:'注册'});
    })
    .post(function(req,res) {
        if (usr.AddUser(req.body.username ,req.body.password2)) {
            res.send('注册成功');
        } else {
            res.send('注册失败');
        }
    });

module.exports = router;

