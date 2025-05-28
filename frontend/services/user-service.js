var UserService = {
    init: function () {
        var token = localStorage.getItem("user_token");
        if (token && token !== undefined) {
            window.location.replace("index.html");
        }
        $("#login-form").validate({
            submitHandler: function (form) {
                var entity = Object.fromEntries(new FormData(form).entries());
                UserService.login(entity);
            },
        });
    },
    login: function (entity) {
        RestClient.authenticate("auth/login", entity, function (result) {
            console.log(result);
            localStorage.setItem("user_token", result.data.token);
            window.location.replace("index.html");
        }, function (error) {
            toastr.error(error?.responseText ? error.responseText : 'Error');
        });
    },
    logout: function () {
        localStorage.clear();
        window.location.replace("login.html");
    },
    generateMenuItems: function(){
        const token = localStorage.getItem("user_token");
        const user = Utils.parseJwt(token).user;
        if (user && user.role){
            let nav = "";
            let main = "";
            switch(user.role) {
                case Constants.USER_ROLE:
                    nav = '<li class="nav-item mx-0 mx-lg-1">'+
                          '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#students">Students</a>'+ 
                          '</li>';
                    $("#tabs").html(nav);
                    main = '<section id="students" data-load="students.html"></section>';
                    $("#spapp").html(main);
                    break;
                case Constants.ADMIN_ROLE:
                    nav = '<li class="nav-item mx-0 mx-lg-1">'+
                          '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#students">Students</a>'+ 
                          '</li>';
                    $("#tabs").html(nav);
                    main = '<section id="students" data-load="students.html"></section>';
                    $("#spapp").html(main);
                    break;
                default:
                    $("#tabs").html(nav);
                    $("#spapp").html(main);
            }
        } else {
            window.location.replace("login.html");
        }
    }
};